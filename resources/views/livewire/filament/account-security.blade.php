<div>
    <div class="space-y-6">
        {{-- Mot de passe --}}
        <x-filament::section
            heading="Mot de passe"
            description="Mettez à jour votre mot de passe de connexion."
        >
            <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                <div style="grid-column:1/-1;">
                    {{ $this->form }}
                </div>
            </div>

            <x-slot name="footer">
                <x-filament::button type="button" icon="heroicon-m-key" wire:click="updatePassword">
                    Mettre à jour le mot de passe
                </x-filament::button>
            </x-slot>
        </x-filament::section>

        {{-- Double authentification --}}
        <x-filament::section
            heading="Double authentification"
            description="Ajoutez une couche de sécurité supplémentaire à votre compte lors de la connexion."
        >
            @if (! $this->user->two_factor_secret)
                {{-- 2FA jamais activée --}}
                <p style="color:var(--gray-400);font-size:0.875rem;line-height:1.6;">
                    Laissez de côté les <a href="https://support.google.com/accounts/answer/1066447" target="_blank" rel="noopener noreferrer" style="color:var(--primary-color);">vérifications en deux étapes</a> et
                    sécurisez votre compte avec une application d’authentification telle que
                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator" target="_blank" rel="noopener noreferrer" style="color:var(--primary-color);">Google Authenticator</a>.
                </p>

                <div style="margin-top:1rem;">
                    <x-filament::button icon="heroicon-m-shield-check" wire:click="enableTwoFactor">
                        Activer
                    </x-filament::button>
                </div>
            @elseif (! $this->user->two_factor_confirmed_at)
                {{-- 2FA activée, en attente de confirmation (QR + code) --}}
                <div style="display:grid;gap:1rem;">
                    <p style="color:var(--gray-400);font-size:0.875rem;line-height:1.6;">
                        Scannez ce QR code avec votre application d’authentification, puis saisissez le code
                        à 6 chiffres pour confirmer l’activation.
                    </p>

                    <div style="padding:0.75rem;border:1px solid var(--gray-200);border-radius:0.75rem;background:#fff;display:inline-flex;">
                        {!! $this->user->twoFactorQrCodeSvg() !!}
                    </div>

                    <div>
                        <p style="font-size:0.75rem;color:var(--gray-400);margin-bottom:0.25rem;">Code secret (à saisir manuellement si le QR n’est pas lisible)</p>
                        <code style="font-family:ui-monospace,monospace;font-size:0.9rem;background:var(--gray-100);padding:0.25rem 0.5rem;border-radius:0.375rem;">
                            {{ $this->twoFactorSecret() }}
                        </code>
                    </div>

                    <x-filament::button wire:click="mountAction('confirmTwoFactor')">
                        Confirmer
                    </x-filament::button>
                </div>
            @else
                {{-- 2FA activée et confirmée --}}
                <div style="display:flex;flex-wrap:wrap;gap:0.75rem;align-items:center;">
                    <span style="font-size:0.875rem;color:var(--success-400);display:inline-flex;align-items:center;gap:0.5rem;">
                        <x-filament::icon icon="heroicon-m-shield-check" style="width:1.1rem;height:1.1rem;" />
                        Activée et confirmée
                    </span>

                    @if ($this->user->two_factor_recovery_codes)
                        <x-filament::badge color="success">Codes de secours disponibles</x-filament::badge>
                    @endif
                </div>

                @if ($showRecoveryCodes && $this->recoveryCodes())
                    <div style="margin-top:1rem;border:1px solid var(--gray-200);border-radius:0.75rem;padding:1rem;">
                        <p style="font-size:0.8rem;color:var(--gray-400);margin-bottom:0.5rem;">
                            Codes de secours — conservez-les précieusement.
                        </p>
                        <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:0.5rem;">
                            @foreach ($this->recoveryCodes() as $recoveryCode)
                                <code style="font-family:ui-monospace,monospace;font-size:0.9rem;background:var(--gray-100);padding:0.25rem 0.5rem;border-radius:0.375rem;">
                                    {{ $recoveryCode }}
                                </code>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div style="display:flex;flex-wrap:wrap;gap:0.75rem;margin-top:1.25rem;">
                    <x-filament::button wire:click="mountAction('regenerateRecoveryCodes')" color="warning" size="sm">
                        Régénérer les codes de secours
                    </x-filament::button>

                    <x-filament::button wire:click="mountAction('disableTwoFactor')" color="danger" size="sm">
                        Désactiver
                    </x-filament::button>
                </div>
            @endif
        </x-filament::section>
    </div>
</div>