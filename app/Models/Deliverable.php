<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deliverable extends Model
{
    use HasFactory;

    protected $fillable = ['engagement_id', 'title', 'due_at', 'done_at'];

    protected function casts(): array
    {
        return ['due_at' => 'date', 'done_at' => 'date'];
    }

    public function engagement(): BelongsTo
    {
        return $this->belongsTo(Engagement::class);
    }
}
