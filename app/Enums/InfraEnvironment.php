<?php

namespace App\Enums;

enum InfraEnvironment: string
{
    case Development = 'development';
    case Staging = 'staging';
    case Production = 'production';

    public function label(): string
    {
        return match ($this) {
            self::Development => 'Development',
            self::Staging => 'Staging',
            self::Production => 'Production',
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
