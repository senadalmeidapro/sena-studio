<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadReminderDigest extends Notification
{
    use Queueable;

    /**
     * @param  array<int, array{id: int, name: string, subject: string, status: string, follow_up_at: ?string, created_at: ?string}>  $leads
     */
    public function __construct(
        public array $leads,
        public string $remindedOn,
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];
        $mailer = config('mail.default');

        if (filled($notifiable->email)
            && filled(config('mail.from.address'))
            && ! in_array($mailer, ['log', 'array'], true)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'kind' => 'lead_reminder_digest',
            'date' => $this->remindedOn,
            'count' => count($this->leads),
            'leads' => $this->leads,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Lead follow-up digest — '.$this->remindedOn)
            ->greeting('Lead follow-up reminder')
            ->line(count($this->leads).' lead(s) need attention:');

        foreach ($this->leads as $lead) {
            $mail->line('#'.$lead['id'].' · '.$lead['name'].' — '.$lead['subject'].' ('.$lead['status'].')');
        }

        return $mail;
    }
}
