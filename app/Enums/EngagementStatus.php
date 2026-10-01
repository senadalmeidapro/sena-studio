<?php

namespace App\Enums;

enum EngagementStatus: string
{
    case Proposal = 'proposal';
    case Active = 'active';
    case Paused = 'paused';
    case Done = 'done';
    case Lost = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::Proposal => 'Proposal',
            self::Active => 'Active',
            self::Paused => 'Paused',
            self::Done => 'Done',
            self::Lost => 'Lost',
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
