<?php

namespace App\Enums;

enum CvSkillLevel: string
{
    case Debutant = 'debutant';
    case Intermediaire = 'intermediaire';
    case Avance = 'avance';
    case Expert = 'expert';

    public function label(): string
    {
        return match ($this) {
            self::Debutant => 'Débutant',
            self::Intermediaire => 'Intermédiaire',
            self::Avance => 'Avancé',
            self::Expert => 'Expert',
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
