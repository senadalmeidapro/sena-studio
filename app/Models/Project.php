<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projects';

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'status' => ProjectStatus::class,
        'type' => ProjectType::class,
        'visibility' => ProjectVisibility::class,
        'featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'role',
        'problem',
        'architecture',
        'technical_decisions',
        'result',
        'result_metric',
        'testimonial_id',
        'featured',
        'sort_order',
        'deployment',
        'url',
        'repository_url',
        'image',
        'cloudinary_public_id',
        'status',
        'type',
        'visibility',
        'started_at',
        'ended_at',
    ];

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable')
            ->withTimestamps();
    }

    public function projectImages(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function testimonial(): BelongsTo
    {
        return $this->belongsTo(Testimonial::class);
    }

    protected static function booted(): void
    {
        static::forceDeleting(function (Project $project): void {
            $project->projectImages()->get()->each->delete();
        });

        static::forceDeleted(function (Project $project): void {
            if (filled($project->cloudinary_public_id)) {
                rescue(fn () => app(CloudinaryService::class)->delete($project->cloudinary_public_id), report: false);
            }
        });
    }
}
