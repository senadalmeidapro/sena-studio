<?php

namespace App\Enums;

enum CvTemplate: string
{
    case Classique = 'classique';
    case Moderne = 'moderne';
    case Minimal = 'minimal';

    public function label(): string
    {
        return match ($this) {
            self::Classique => 'Classique',
            self::Moderne => 'Moderne',
            self::Minimal => 'Minimal',
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
