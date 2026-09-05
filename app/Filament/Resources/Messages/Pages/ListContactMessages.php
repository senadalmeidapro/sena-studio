<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\ContactMessageResource;
use Filament\Resources\Pages\ListRecords;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;
}
