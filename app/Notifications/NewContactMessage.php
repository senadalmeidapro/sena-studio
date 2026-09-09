<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification
{
    use Queueable;

    public function __construct(public ContactMessage $message) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'from' => $this->message->name.' <'.$this->message->email.'>',
            'subject' => $this->message->subject,
            'url' => route('filament.admin.resources.contact-messages.view', $this->message),
        ];
    }
}
