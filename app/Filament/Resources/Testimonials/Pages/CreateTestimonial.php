<?php

namespace App\Filament\Resources\Testimonials\Pages;

use App\Filament\Resources\Concerns\HandlesCloudinaryImages;
use App\Filament\Resources\Testimonials\TestimonialResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTestimonial extends CreateRecord
{
    use HandlesCloudinaryImages;

    protected static string $resource = TestimonialResource::class;

    protected function afterCreate(): void
    {
        $this->uploadLocalImageToCloudinary('avatar', 'sena-studio/testimonials');
    }
}
