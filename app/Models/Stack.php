<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Stack
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|StackItem[] $stack_items
 * @property Collection|Project[] $projects
 *
 * @package App\Models
 */
class Stack extends Model
{
	protected $table = 'stacks';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'description',
		'is_active'
	];

	public function stack_items(): HasMany
	{
		return $this->hasMany(StackItem::class);
	}

	public function projects(): HasMany
	{
		return $this->hasMany(Project::class);
	}
}
