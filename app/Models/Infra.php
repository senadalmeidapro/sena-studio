<?php

namespace App\Models;

use App\Enums\InfraEnvironment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Infra extends Model
{
    use HasFactory;

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
