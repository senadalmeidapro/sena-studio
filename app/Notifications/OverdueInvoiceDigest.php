<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OverdueInvoiceDigest extends Notification
{
    use Queueable;

    public function __construct(public array $invoices, public string $remindedOn) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'kind' => 'overdue-invoice-digest',
            'reminded_on' => $this->remindedOn,
            'count' => count($this->invoices),
            'invoices' => $this->invoices,
        ];
    }
}
