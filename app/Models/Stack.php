<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stack extends Model
{
    use HasFactory;

    protected $table = 'stacks';

    protected $casts = [
        'is_active' => 'bool',
    ];

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function stackItems(): HasMany
    {
        return $this->hasMany(StackItem::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
