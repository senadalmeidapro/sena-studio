<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Concerns\HandlesCloudinaryImages;
use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    use HandlesCloudinaryImages;

    protected static string $resource = PostResource::class;

    protected function afterCreate(): void
    {
        $this->uploadLocalImageToCloudinary('cover_image', 'sena-studio/posts');
    }
}
