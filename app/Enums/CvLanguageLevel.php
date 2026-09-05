<?php

namespace App\Enums;

enum CvLanguageLevel: string
{
    case Debutant = 'debutant';
    case Intermediaire = 'intermediaire';
    case Courant = 'courant';
    case Avance = 'avance';
    case Natif = 'natif';

    public function label(): string
    {
        return match ($this) {
            self::Debutant => 'Débutant',
            self::Intermediaire => 'Intermédiaire',
            self::Courant => 'Courant',
            self::Avance => 'Avancé',
            self::Natif => 'Natif',
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
