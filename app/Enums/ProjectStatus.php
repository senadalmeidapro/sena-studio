<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Development = 'development';
    case Testing = 'testing';
    case Production = 'production';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Development => 'Development',
            self::Testing => 'Testing',
            self::Production => 'Production',
            self::Cancelled => 'Cancelled',
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
