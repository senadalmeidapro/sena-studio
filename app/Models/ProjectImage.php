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
            if (filled($image->cloudinary_public_id)) {
                rescue(fn () => app(CloudinaryService::class)->delete($image->cloudinary_public_id), report: false);
            }
        });
    }
}
