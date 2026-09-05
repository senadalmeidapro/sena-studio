<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Security extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLockClosed;

    protected static UnitEnum|string|null $navigationGroup = 'Compte';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Sécurité du compte';

    protected static ?string $navigationLabel = 'Sécurité';

    protected string $view = 'filament.pages.security';
}
