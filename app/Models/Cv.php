<?php

namespace App\Models;

use App\Enums\CvStatus;
use App\Enums\CvTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'version_label',
        'slug',
        'template',
        'status',
        'accent_color',
        'is_primary',
        'headline',
        'email',
        'phone',
        'location',
        'website',
        'summary',
        'links',
        'experience',
        'education',
        'skills',
        'languages',
        'certifications',
        'hobbies',
    ];

    protected $casts = [
        'template' => CvTemplate::class,
        'status' => CvStatus::class,
        'is_primary' => 'boolean',
        'links' => 'array',
        'experience' => 'array',
        'education' => 'array',
        'skills' => 'array',
        'languages' => 'array',
        'certifications' => 'array',
        'hobbies' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Cv $cv): void {
            if (blank($cv->slug)) {
                $cv->slug = Str::slug($cv->version_label ?: $cv->title).'-'.Str::lower(Str::random(4));
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', CvStatus::Published);
    }

    public function scopePrimary(Builder $query): Builder
    {
        return $query->where('is_primary', true);
    }

    public function isPublished(): bool
    {
        return $this->status === CvStatus::Published;
    }

    public function makePrimary(): void
    {
        self::query()
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        $this->forceFill(['is_primary' => true])->save();
    }

    public function accentStyle(): string
    {
        return $this->accent_color ?: '#059669';
    }

    public function contacts(): array
    {
        return array_filter([
            'Email' => $this->email,
            'Téléphone' => $this->phone,
            'Localisation' => $this->location,
            'Site web' => $this->website,
        ], fn (?string $value): bool => filled($value));
    }
}
