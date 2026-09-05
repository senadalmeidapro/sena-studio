<?php

namespace App\Livewire\Filament;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\Fortify;
use Livewire\Component;

class AccountSecurity extends Component implements HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public User $user;

    public array $data = [];

    public bool $showRecoveryCodes = false;

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('current_password')
                    ->label('Mot de passe actuel')
                    ->password()
                    ->revealable()
                    ->autocomplete('current-password'),

                TextInput::make('password')
                    ->label('Nouveau mot de passe')
                    ->password()
                    ->revealable()
                    ->autocomplete('new-password')
                    ->rule(Password::min(8)->letters()->mixedCase()->numbers()->symbols()),

                TextInput::make('password_confirmation')
                    ->label('Confirmer le nouveau mot de passe')
                    ->password()
                    ->revealable()
                    ->same('password'),
            ])
            ->statePath('data');
    }

    public function updatePassword(): void
    {
        $data = $this->form->getState();

        if (! Hash::check((string) $data['current_password'], $this->user->password)) {
            Notification::make()
                ->title('Le mot de passe actuel est incorrect.')
                ->danger()
                ->send();

            return;
        }

        $this->user->forceFill([
            'password' => Hash::make((string) $data['password']),
        ])->save();

        $this->form->fill([
            'current_password' => null,
            'password' => null,
            'password_confirmation' => null,
        ]);

        Notification::make()
            ->title('Mot de passe mis à jour avec succès.')
            ->success()
            ->send();
    }

    public function enableTwoFactor(): void
    {
        app(EnableTwoFactorAuthentication::class)($this->user);
        Notification::make()
            ->title('Scannez le code QR pour configurer votre application d’authentification.')
            ->info()
            ->send();
    }

    public function confirmTwoFactorAction(): Action
    {
        return Action::make('confirmTwoFactor')
            ->label('Confirmer')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Confirmer la double authentification')
            ->modalDescription('Saisissez le code à 6 chiffres affiché par votre application d’authentification (Google Authenticator, 1Password…).')
            ->modalSubmitActionLabel('Confirmer')
            ->modalWidth(MaxWidth::Medium)
            ->schema([
                TextInput::make('code')
                    ->label('Code TOTP')
                    ->numeric()
                    ->length(6)
                    ->required(),
            ])
            ->action(fn (array $data): mixed => $this->confirmTwoFactor($data['code'] ?? null));
    }

    public function backupCodeAction(): Action
    {
        return Action::make('backupCode')
            ->label('Activer avec un code de secours')
            ->color('gray')
            ->schema([
                TextInput::make('code')
                    ->label('Code de secours')
                    ->required(),
            ])
            ->action(fn (array $data): mixed => $this->confirmTwoFactor($data['code'] ?? null, true));
    }

    public function regenerateRecoveryCodesAction(): Action
    {
        return Action::make('regenerateRecoveryCodes')
            ->label('Régénérer les codes de secours')
            ->color('warning')
            ->requiresConfirmation()
            ->action(function (): void {
                app(GenerateNewRecoveryCodes::class)($this->user);
                $this->showRecoveryCodes = true;
                Notification::make()
                    ->title('Nouveaux codes de secours générés.')
                    ->success()
                    ->send();
            });
    }

    public function disableTwoFactorAction(): Action
    {
        return Action::make('disableTwoFactor')
            ->label('Désactiver')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (): void {
                app(DisableTwoFactorAuthentication::class)($this->user);
                Notification::make()
                    ->title('Double authentification désactivée.')
                    ->success()
                    ->send();
            });
    }

    protected function confirmTwoFactor(?string $code, bool $recovery = false): void
    {
        if (blank($code)) {
            Notification::make()->title('Veuillez saisir un code.')->danger()->send();

            return;
        }

        try {
            // Valide le code TOTP contre le secret courant (décrypté).
            $secret = Fortify::currentEncrypter()->decrypt($this->user->two_factor_secret);

            $valid = $recovery
                ? $this->usesRecoveryCode($code)
                : app(TwoFactorAuthenticationProvider::class)->verify($secret, $code);

            if (! $valid) {
                Notification::make()->title('Code invalide, réessayez.')->danger()->send();

                return;
            }

            $this->user->forceFill([
                'two_factor_confirmed_at' => now(),
            ])->save();

            Notification::make()
                ->title($recovery ? 'Double authentification activée de secours.' : 'Double authentification activée.')
                ->success()
                ->send();

            $this->showRecoveryCodes = true;
        } catch (\Throwable $e) {
            Notification::make()->title('Impossible de valider ce code.')->danger()->send();
        }
    }

    protected function usesRecoveryCode(string $code): bool
    {
        foreach (json_decode(Fortify::currentEncrypter()->decrypt($this->user->two_factor_recovery_codes), true) as $recoveryCode) {
            if (hash_equals($recoveryCode, $code)) {
                $updatedMenu = collect(json_decode(Fortify::currentEncrypter()->decrypt($this->user->two_factor_recovery_codes), true))
                    ->reject(fn ($c) => $c === $code)
                    ->values()->all();

                $this->user->forceFill([
                    'two_factor_recovery_codes' => Fortify::currentEncrypter()->encrypt(json_encode($updatedMenu)),
                ])->save();

                return true;
            }
        }

        return false;
    }

    public function twoFactorSecret(): ?string
    {
        if (blank($this->user->two_factor_secret)) {
            return null;
        }

        return Fortify::currentEncrypter()->decrypt($this->user->two_factor_secret);
    }

    public function qrCodeUrl(): ?string
    {
        $secret = $this->twoFactorSecret();

        if (! $secret) {
            return null;
        }

        $applicationName = config('app.name', 'Laravel');

        return sprintf(
            'otpauth://totp/%s:%s?issuer=%s&secret=%s',
            rawurlencode((string) $applicationName),
            rawurlencode((string) $this->user->email),
            rawurlencode((string) $applicationName),
            $secret,
        );
    }

    public function recoveryCodes(): array
    {
        if (blank($this->user->two_factor_recovery_codes)) {
            return [];
        }

        return json_decode(Fortify::currentEncrypter()->decrypt($this->user->two_factor_recovery_codes), true);
    }

    public function render()
    {
        return view('livewire.filament.account-security');
    }
}
