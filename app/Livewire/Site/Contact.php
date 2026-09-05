<?php

namespace App\Livewire\Site;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

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

    public bool $sent = false;

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
        ];
    }

    public function submit(): void
    {
        $data = $this->validate();

        ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'company' => $data['company'] ?: null,
            'subject' => $data['subject'],
            'budget' => $data['budget'] ?: null,
            'message' => $data['message'],
        ]);

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

        $this->reset('name', 'email', 'phone', 'company', 'subject', 'budget', 'message');
        $this->sent = true;
    }

    public function render()
    {
        return view('pages.public.contact');
    }
}
