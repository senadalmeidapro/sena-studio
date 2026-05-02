<?php

namespace App\Enums;

enum ProjectType: string
{
    case Web = 'web';
    case App = 'app';
    case Software = 'software';

    public function label(): string
    {
        return match ($this) {
            self::Web => 'Web',
            self::App => 'App',
            self::Software => 'Software',
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
