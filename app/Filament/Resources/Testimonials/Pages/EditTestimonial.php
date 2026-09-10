<?php

namespace App\Filament\Resources\Testimonials\Pages;

use App\Filament\Resources\Concerns\HandlesCloudinaryImages;
use App\Filament\Resources\Testimonials\TestimonialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTestimonial extends EditRecord
{
    use HandlesCloudinaryImages;

    protected static string $resource = TestimonialResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->cloudinaryFormImage($data, 'avatar', 'sena-studio/testimonials');
    }

    protected function afterDelete(): void
    {
        rescue(fn () => $this->deleteCloudinaryAsset($this->record->cloudinary_public_id), report: false);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
