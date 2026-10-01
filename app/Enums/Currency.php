<?php

namespace App\Enums;

enum Currency: string
{
    case XOF = 'XOF';
    case EUR = 'EUR';

    public function label(): string
    {
        return $this->value;
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
