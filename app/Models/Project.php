<?php

namespace App\Models;

use App\Enums\ProjectComplexity;
use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
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
        'price' => 'float',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'stack_id' => 'int',
        'infra_id' => 'int',
        'status' => ProjectStatus::class,
        'type' => ProjectType::class,
        'complexity' => ProjectComplexity::class,
        'visibility' => ProjectVisibility::class,
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'version',
        'price',
        'url',
        'repository_url',
        'image',
        'status',
        'type',
        'complexity',
        'visibility',
        'started_at',
        'ended_at',
        'stack_id',
        'infra_id',
    ];

    public function stack(): BelongsTo
    {
        return $this->belongsTo(Stack::class);
    }

    public function infra(): BelongsTo
    {
        return $this->belongsTo(Infra::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class)
            ->withPivot('id', 'proficiency')
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
}
