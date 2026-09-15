<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Concerns\HandlesCloudinaryImages;
use App\Filament\Resources\Posts\PostResource;
use App\Models\AdminActivityLog;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    use HandlesCloudinaryImages;

    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->cloudinaryFormImage($data, 'cover_image');
    }

    protected function afterCreate(): void
    {
        AdminActivityLog::record('posts.create', "Article Â« {$this->record->title} Â» crÃ©Ã©.", $this->record);
    }
}
