<?php

namespace App\Models;

use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonials';

    protected $casts = [
        'is_visible' => 'bool',
        'sort_order' => 'int',
    ];

    protected $fillable = [
        'name',
        'role',
        'company',
        'avatar',
        'cloudinary_public_id',
        'content',
        'sort_order',
        'is_visible',
    ];

    public function scopeVisible(Builder $query): Builder
    {
        return $query
            ->where('is_visible', true)
            ->orderBy('sort_order');
    }

    protected static function booted(): void
    {
        static::deleted(function (Testimonial $testimonial): void {
            if (filled($testimonial->cloudinary_public_id)) {
                rescue(fn () => app(CloudinaryService::class)->delete($testimonial->cloudinary_public_id), report: false);
            }
        });
    }
}
