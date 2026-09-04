<?php

namespace App\Models;

use App\Enums\StackItemCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StackItem extends Model
{
    use HasFactory;

    protected $table = 'stack_items';

    protected $casts = [
        'stack_id' => 'int',
        'category' => StackItemCategory::class,
    ];

    protected $fillable = [
        'stack_id',
        'category',
        'value',
        'version',
    ];

    public function stack(): BelongsTo
    {
        return $this->belongsTo(Stack::class);
    }
}
