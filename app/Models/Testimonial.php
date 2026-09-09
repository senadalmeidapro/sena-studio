<?php

namespace App\Models;

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
}
