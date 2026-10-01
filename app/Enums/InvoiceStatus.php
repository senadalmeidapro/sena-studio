<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Paid = 'paid';
    case Overdue = 'overdue';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Sent => 'Sent',
            self::Paid => 'Paid',
            self::Overdue => 'Overdue',
        };
    }

    public static function options(): array
    {
        return array_column(
            array_map(fn (self $case): array => [$case->value, $case->label()], self::cases()),
            1,
            0,
        );
    }
}
