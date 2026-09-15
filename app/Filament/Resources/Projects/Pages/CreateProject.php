<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Concerns\HandlesCloudinaryImages;
use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    use HandlesCloudinaryImages;

    protected static string $resource = ProjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->cloudinaryFormImage($data, 'image');
    }

    protected function afterCreate(): void
    {
        $this->normalizeCloudinaryProjectImages();
    }
}
