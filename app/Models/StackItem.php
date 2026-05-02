<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
 *
 * @property Stack $stack
 *
 * @package App\Models
 */
class StackItem extends Model
{
	protected $table = 'stack_items';

	protected $casts = [
		'stack_id' => 'int'
	];

	protected $fillable = [
		'stack_id',
		'category',
		'value',
		'version'
	];

	public function stack()
	{
		return $this->belongsTo(Stack::class);
	}
}
