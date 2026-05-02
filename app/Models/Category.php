<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Categorizable[] $categorizables
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'sort_order' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'description',
		'sort_order'
	];

	public function categorizables(): HasMany
	{
		return $this->hasMany(Categorizable::class);
	}

	public function skills(): MorphToMany
	{
		return $this->morphedByMany(Skill::class, 'categorizable')
			->withTimestamps();
	}
}
