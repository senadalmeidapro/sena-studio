<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    public const STATUS_NEW = 'new';

    public const STATUS_QUALIFYING = 'qualifying';

    public const STATUS_PROPOSAL = 'proposal';

    public const STATUS_WON = 'won';

    public const STATUS_LOST = 'lost';

    public const PRIORITY_LOW = 'low';

    public const PRIORITY_NORMAL = 'normal';

    public const PRIORITY_HIGH = 'high';

    protected $table = 'contact_messages';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'budget',
        'message',
        'status',
        'priority',
        'follow_up_at',
        'internal_notes',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'follow_up_at' => 'datetime',
    ];

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_NEW => 'Nouveau',
            self::STATUS_QUALIFYING => 'En qualification',
            self::STATUS_PROPOSAL => 'Proposition envoyée',
            self::STATUS_WON => 'Gagné',
            self::STATUS_LOST => 'Perdu',
        ];
    }

    public static function priorityOptions(): array
    {
        return [
            self::PRIORITY_LOW => 'Basse',
            self::PRIORITY_NORMAL => 'Normale',
            self::PRIORITY_HIGH => 'Haute',
        ];
    }

    public function statusLabel(): string
    {
        return self::statusOptions()[$this->status] ?? (string) $this->status;
    }

    public function priorityLabel(): string
    {
        return self::priorityOptions()[$this->priority] ?? (string) $this->priority;
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function budgetLabel(): ?string
    {
        $labels = [
            'moins-1k' => 'Moins de 1 000 €',
            '1k-5k' => '1 000 € – 5 000 €',
            '5k-15k' => '5 000 € – 15 000 €',
            'plus-15k' => 'Plus de 15 000 €',
            'a-definir' => 'À définir ensemble',
        ];

        return $this->budget !== null ? ($labels[$this->budget] ?? $this->budget) : null;
    }
}
