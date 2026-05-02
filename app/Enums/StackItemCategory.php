<?php

namespace App\Enums;

enum StackItemCategory: string
{
    case Frontend = 'frontend';
    case Backend = 'backend';
    case Database = 'database';
    case Cache = 'cache';
    case Queue = 'queue';
    case Orm = 'orm';
    case Storage = 'storage';
    case Cloud = 'cloud';
    case Monitoring = 'monitoring';
    case Analytics = 'analytics';
    case Devops = 'devops';
    case Design = 'design';
    case Testing = 'testing';
    case Documentation = 'documentation';
    case Others = 'others';

    public function label(): string
    {
        return match ($this) {
            self::Frontend => 'Frontend',
            self::Backend => 'Backend',
            self::Database => 'Database',
            self::Cache => 'Cache',
            self::Queue => 'Queue',
            self::Orm => 'ORM',
            self::Storage => 'Storage',
            self::Cloud => 'Cloud',
            self::Monitoring => 'Monitoring',
            self::Analytics => 'Analytics',
            self::Devops => 'Devops',
            self::Design => 'Design',
            self::Testing => 'Testing',
            self::Documentation => 'Documentation',
            self::Others => 'Others',
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
