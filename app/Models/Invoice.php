<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['engagement_id', 'number', 'amount', 'currency', 'issued_at', 'due_at', 'paid_at', 'status'];

    protected function casts(): array
    {
        return ['amount' => 'integer', 'currency' => Currency::class, 'status' => InvoiceStatus::class, 'issued_at' => 'date', 'due_at' => 'date', 'paid_at' => 'date'];
    }

    public function engagement(): BelongsTo
    {
        return $this->belongsTo(Engagement::class);
    }
}
