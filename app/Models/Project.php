<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $version
 * @property float $price
 * @property string|null $url
 * @property string|null $repository_url
 * @property string|null $image
 * @property string $status
 * @property string $type
 * @property string $complexity
 * @property string $visibility
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property int|null $stack_id
 * @property int|null $infra_id
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Stack|null $stack
 * @property Infra|null $infra
 * @property Collection|Skill[] $skills
 *
 * @package App\Models
 */
class Project extends Model
{
	use SoftDeletes;
	protected $table = 'projects';

	protected $casts = [
		'price' => 'float',
		'started_at' => 'datetime',
		'ended_at' => 'datetime',
		'stack_id' => 'int',
		'infra_id' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'description',
		'version',
		'price',
		'url',
		'repository_url',
		'image',
		'status',
		'type',
		'complexity',
		'visibility',
		'started_at',
		'ended_at',
		'stack_id',
		'infra_id'
	];

	public function stack()
	{
		return $this->belongsTo(Stack::class);
	}

	public function infra()
	{
		return $this->belongsTo(Infra::class);
	}

	public function skills()
	{
		return $this->belongsToMany(Skill::class)
					->withPivot('id', 'proficiency')
					->withTimestamps();
	}
}
