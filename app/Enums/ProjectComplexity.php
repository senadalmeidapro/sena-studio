<?php

namespace App\Enums;

enum ProjectComplexity: string
{
    case Simple = 'simple';
    case Medium = 'medium';
    case Complex = 'complex';

    public function label(): string
    {
        return match ($this) {
            self::Simple => 'Simple',
            self::Medium => 'Medium',
            self::Complex => 'Complex',
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
