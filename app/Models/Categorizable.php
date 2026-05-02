<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Categorizable
 * 
 * @property int $id
 * @property int $category_id
 * @property string $categorizable_type
 * @property int $categorizable_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Category $category
 *
 * @package App\Models
 */
class Categorizable extends Model
{
	protected $table = 'categorizables';

	protected $casts = [
		'category_id' => 'int',
		'categorizable_id' => 'int'
	];

	protected $fillable = [
		'category_id',
		'categorizable_type',
		'categorizable_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}
}
