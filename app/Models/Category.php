<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $casts = [
        'sort_order' => 'int',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
    ];

    public function skills(): MorphToMany
    {
        return $this->morphedByMany(Skill::class, 'categorizable')
            ->withTimestamps();
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'categorizable')
            ->withTimestamps();
    }
}
