<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    use HasFactory;

    protected $table = 'skills';

    protected $casts = [
        'is_active' => 'bool',
    ];

    protected $fillable = [
        'name',
        'description',
        'category',
        'is_active',
        'icon',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)
            ->withPivot('id')
            ->withTimestamps();
    }
}
