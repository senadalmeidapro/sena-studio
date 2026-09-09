<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $table = 'page_views';

    public $timestamps = false;

    protected $fillable = [
        'path',
        'route_name',
        'locale',
        'referer',
        'user_agent',
        'ip_hash',
        'is_bot',
        'created_at',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_bot', false);
    }

    public function scopeSince(Builder $query, int $days): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
