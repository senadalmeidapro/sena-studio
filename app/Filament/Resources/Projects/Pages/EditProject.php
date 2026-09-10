<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Concerns\HandlesCloudinaryImages;
use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    use HandlesCloudinaryImages;

    protected static string $resource = ProjectResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->cloudinaryFormImage($data, 'image', 'sena-studio/projects');
    }
}
