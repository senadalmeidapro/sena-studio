<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\StackItemCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class StackItem
 *
 * @property int $id
 * @property int $stack_id
 * @property string $category
 * @property string $value
 * @property string|null $version
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Stack $stack
 */
class StackItem extends Model
{
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
