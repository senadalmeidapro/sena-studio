<?php

namespace App\Models;

use App\Enums\SkillLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Skill extends Model
{
    use HasFactory;

    protected $table = 'skills';

    protected $casts = [
        'is_active' => 'bool',
        'level' => SkillLevel::class,
    ];

    protected $fillable = [
        'name',
        'description',
        'level',
        'is_active',
        'icon',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->withPivot('id', 'proficiency')
            ->withTimestamps();
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable')
            ->withTimestamps();
    }
}
