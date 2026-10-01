<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting as SiteSettingModel;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Site availability';

    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSettingModel::current()->only(['availability', 'booking_url']));
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('availability')->options([
                'available' => 'Available',
                'limited' => 'Limited availability',
                'unavailable' => 'Unavailable',
            ])->required(),
            TextInput::make('booking_url')->label('Booking URL')->url()->maxLength(255)->nullable(),
        ])->statePath('data');
    }

    public function save(): void
    {
        SiteSettingModel::current()->update($this->form->getState());
        Notification::make()->title('Site settings saved.')->success()->send();
    }
}
