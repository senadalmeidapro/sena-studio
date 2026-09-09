<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected $table = 'posts';

    protected $casts = [
        'published_at' => 'datetime',
        'user_id' => 'int',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'status',
        'published_at',
        'seo_title',
        'seo_description',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable')
            ->withTimestamps();
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            if ($post->status === self::STATUS_PUBLISHED && $post->published_at === null) {
                $post->published_at = now();
            }

            if ($post->status !== self::STATUS_PUBLISHED) {
                $post->published_at = null;
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeVisibleFront(Builder $query): Builder
    {
        return $this->scopePublished($query);
    }

    public function readingMinutes(): int
    {
        $minuteCharacters = 1200;

        return max(1, intdiv(mb_strlen(strip_tags((string) $this->content)), $minuteCharacters));
    }
}
