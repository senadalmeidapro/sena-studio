<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'budget',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
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
