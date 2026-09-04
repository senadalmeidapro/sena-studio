<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectSkill
 *
 * @property int $id
 * @property int $project_id
 * @property int $skill_id
 * @property string $proficiency
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Project $project
 * @property Skill $skill
 */
class ProjectSkill extends Model
{
    protected $table = 'project_skill';

    protected $casts = [
        'project_id' => 'int',
        'skill_id' => 'int',
    ];

    protected $fillable = [
        'project_id',
        'skill_id',
        'proficiency',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
