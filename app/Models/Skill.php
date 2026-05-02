<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Skill
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $level
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Project[] $projects
 *
 * @package App\Models
 */
class Skill extends Model
{
	protected $table = 'skills';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'description',
		'level',
		'is_active'
	];

	public function projects()
	{
		return $this->belongsToMany(Project::class)
					->withPivot('id', 'proficiency')
					->withTimestamps();
	}
}
