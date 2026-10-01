<?php

namespace App\Enums;

enum EngagementPricingModel: string
{
    case Fixed = 'fixed';
    case DailyRate = 'daily_rate';
    case Retainer = 'retainer';

    public function label(): string
    {
        return match ($this) {
            self::Fixed => 'Fixed scope',
            self::DailyRate => 'Daily rate',
            self::Retainer => 'Retainer',
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
