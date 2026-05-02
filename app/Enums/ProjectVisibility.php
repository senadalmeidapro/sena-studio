<?php

namespace App\Enums;

enum ProjectVisibility: string
{
    case Public = 'public';
    case Private = 'private';
    case Protected = 'protected';

    public function label(): string
    {
        return match ($this) {
            self::Public => 'Public',
            self::Private => 'Private',
            self::Protected => 'Protected',
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
