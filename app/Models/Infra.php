<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\InfraEnvironment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Infra
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $docker_image
 * @property string|null $kubernetes_config
 * @property string|null $helm_chart
 * @property int $cpu_cores
 * @property int $memory_mb
 * @property int $storage_gb
 * @property string $environment
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|Project[] $projects
 */
class Infra extends Model
{
    protected $table = 'infras';

    protected $casts = [
        'cpu_cores' => 'int',
        'memory_mb' => 'int',
        'storage_gb' => 'int',
        'is_active' => 'bool',
        'environment' => InfraEnvironment::class,
    ];

    protected $fillable = [
        'name',
        'description',
        'docker_image',
        'kubernetes_config',
        'helm_chart',
        'cpu_cores',
        'memory_mb',
        'storage_gb',
        'environment',
        'is_active',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
