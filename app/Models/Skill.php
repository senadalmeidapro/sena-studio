<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\SkillLevel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Skill
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $level
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|Project[] $projects
 */
class Skill extends Model
{
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
