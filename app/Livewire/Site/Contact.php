<?php

namespace App\Livewire\Site;

use App\Models\ContactMessage;
use App\Models\ModelHasRole;
use App\Models\User;
use App\Notifications\NewContactMessage;
use App\Services\Seo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;

#[Title('Contact — Sena Studio')]
#[Layout('layouts.public')]
class Contact extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $company = '';

    public string $subject = '';

    public string $budget = '';

    public string $message = '';

    public string $website = '';

    public bool $sent = false;

    public function mount(): void
    {
        app(Seo::class)->set(
            title: null,
            description: 'Discutons de votre projet — devis gratuit sous 48 h, outillage moderne et interlocuteur unique.',
            canonical: url()->route('contact'),
        );
    }

    public function budgetOptions(): array
    {
        return [
            'moins-1k' => 'Moins de 1 000 €',
            '1k-5k' => '1 000 € – 5 000 €',
            '5k-15k' => '5 000 € – 15 000 €',
            'plus-15k' => 'Plus de 15 000 €',
            'a-definir' => 'À définir ensemble',
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:160'],
            'subject' => ['required', 'string', 'max:160'],
            'budget' => ['nullable', Rule::in(array_keys($this->budgetOptions()))],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            'website' => ['sometimes', 'max:0'],
        ];
    }

    public function submit(): void
    {
        // Honeypot : champ invisible, rempli uniquement par les bots.
        if ($this->website !== '') {
            $this->sent = true;

            return;
        }

        $data = $this->validate();
        $key = 'contact:'.md5(request()->ip().'|'.strtolower($data['email']));

        $allowed = RateLimiter::attempt(
            $key,
            maxAttempts: 3,
            callback: fn () => $this->store($data),
            decaySeconds: 3600,
        );

        if (! $allowed) {
            $this->addError('email', 'Trop de messages envoyés. Réessayez dans une heure.');

            return;
        }

        $this->sent = true;
    }

    protected function store(array $data): void
    {
        $message = ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'company' => $data['company'] ?: null,
            'subject' => $data['subject'],
            'budget' => $data['budget'] ?: null,
            'message' => $data['message'],
        ]);

        $this->notifyAdmins($message);

        try {
            $this->sendMail($data);
        } catch (Throwable) {
            // L'envoi d'email reste best-effort : le message est déjà enregistré.
            report(new \RuntimeException('Échec de l\'envoi du mail de contact pour '.$data['email']));
        }

        $this->reset('name', 'email', 'phone', 'company', 'subject', 'budget', 'message');
    }

    protected function notifyAdmins(ContactMessage $message): void
    {
        $adminIds = ModelHasRole::query()->pluck('model_id')->filter()->unique()->all();

        if ($adminIds === []) {
            return;
        }

        User::query()->whereIn('id', $adminIds)->get()->each->notify(new NewContactMessage($message));
    }

    protected function sendMail(array $data): void
    {
        $lines = [
            "Nom : {$data['name']}",
            "Email : {$data['email']}",
        ];

        if ($data['company']) {
            $lines[] = "Société : {$data['company']}";
        }

        if ($data['phone']) {
            $lines[] = "Téléphone : {$data['phone']}";
        }

        if ($data['budget']) {
            $lines[] = 'Budget : '.($this->budgetOptions()[$data['budget']] ?? $data['budget']);
        }

        $lines[] = '';
        $lines[] = $data['message'];

        Mail::raw(
            implode("\n", $lines),
            function ($message) use ($data) {
                $message->to(config('mail.from.address'))
                    ->replyTo($data['email'], $data['name'])
                    ->subject('[Sena Studio] '.$data['subject']);
            },
        );
    }

    public function render()
    {
        return view('pages.public.contact');
    }
}
