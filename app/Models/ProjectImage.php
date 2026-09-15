<?php

namespace App\Models;

use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    protected $table = 'project_images';

    protected $fillable = [
        'project_id',
        'path',
        'cloudinary_public_id',
        'caption',
        'sort_order',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    protected static function booted(): void
    {
        static::deleted(function (ProjectImage $image): void {
            $service = app(CloudinaryService::class);
            $publicId = $image->cloudinary_public_id
                ?: (is_string($image->path) ? $service->publicIdFromUrl($image->path) : null);

            if (filled($publicId)) {
                rescue(fn () => $service->delete($publicId), report: false);
            }
        });
    }
}
