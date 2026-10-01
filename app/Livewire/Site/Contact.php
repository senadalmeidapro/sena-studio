<?php

namespace App\Livewire\Site;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
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

    public string $project_type = '';

    public string $goal = '';

    public string $timeline = '';

    public string $budget_range = '';

    public string $message = '';

    public string $website = '';

    public ?string $bookingUrl = null;

    public string $availability = 'available';

    public bool $sent = false;

    public function mount(): void
    {
        $settings = SiteSetting::current();
        $this->bookingUrl = $settings->booking_url;
        $this->availability = $settings->availability;

        app(Seo::class)->set(
            title: null,
            description: __('seo.contact_description'),
            canonical: localized_route('contact'),
        );
    }

    public function budgetOptions(): array
    {
        return [
            'moins-1k' => __('contact.budget_less_1k'),
            '1k-5k' => __('contact.budget_1k_5k'),
            '5k-15k' => __('contact.budget_5k_15k'),
            'plus-15k' => __('contact.budget_more_15k'),
            'a-definir' => __('contact.budget_to_define'),
        ];
    }

    public function projectTypeOptions(): array
    {
        return [
            'fintech_api' => __('contact.project_type_fintech_api'),
            'edtech_platform' => __('contact.project_type_edtech_platform'),
            'product_backend' => __('contact.project_type_product_backend'),
            'other' => __('contact.project_type_other'),
        ];
    }

    public function timelineOptions(): array
    {
        return [
            'under_1_month' => __('contact.timeline_under_1_month'),
            '1_3_months' => __('contact.timeline_1_3_months'),
            '3_6_months' => __('contact.timeline_3_6_months'),
            'flexible' => __('contact.timeline_flexible'),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:160'],
            'project_type' => ['required', Rule::in(array_keys($this->projectTypeOptions()))],
            'goal' => ['required', 'string', 'min:10', 'max:1000'],
            'timeline' => ['required', Rule::in(array_keys($this->timelineOptions()))],
            'budget_range' => ['required', Rule::in(array_keys($this->budgetOptions()))],
            'message' => ['nullable', 'string', 'max:5000'],
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
            $this->addError('email', __('contact.ratelimit'));

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
            'subject' => $this->projectTypeOptions()[$data['project_type']],
            'project_type' => $data['project_type'],
            'goal' => $data['goal'],
            'timeline' => $data['timeline'],
            'budget_range' => $data['budget_range'],
            'message' => $data['message'] ?: null,
        ]);

        $this->notifyAdmins($message);

        try {
            $this->sendMail($data);
        } catch (Throwable) {
            // L'envoi d'email reste best-effort : le message est déjà enregistré.
            report(new \RuntimeException('Échec de l\'envoi du mail de contact pour '.$data['email']));
        }

        $this->reset('name', 'email', 'phone', 'company', 'project_type', 'goal', 'timeline', 'budget_range', 'message');
    }

    protected function notifyAdmins(ContactMessage $message): void
    {
        User::query()->where('is_admin', true)->get()->each->notify(new NewContactMessage($message));
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

        $lines[] = 'Project type: '.($this->projectTypeOptions()[$data['project_type']] ?? $data['project_type']);
        $lines[] = 'Goal: '.$data['goal'];
        $lines[] = 'Timeline: '.($this->timelineOptions()[$data['timeline']] ?? $data['timeline']);
        $lines[] = 'Budget: '.($this->budgetOptions()[$data['budget_range']] ?? $data['budget_range']);
        if (filled($data['message'] ?? null)) {
            $lines[] = '';
            $lines[] = $data['message'];
        }

        Mail::raw(
            implode("\n", $lines),
            function ($message) use ($data) {
                $message->to(config('mail.from.address'))
                    ->replyTo($data['email'], $data['name'])
                    ->subject('[Sena Studio] '.$this->projectTypeOptions()[$data['project_type']]);
            },
        );
    }

    public function render()
    {
        return view('pages.public.contact');
    }
}
