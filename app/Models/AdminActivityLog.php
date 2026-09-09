<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AdminActivityLog extends Model
{
    protected $table = 'admin_activity_logs';

    protected $casts = [
        'user_id' => 'int',
    ];

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'auditable_type',
        'auditable_id',
        'ip_address',
        'user_agent',
    ];

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, ?string $description = null, ?Model $auditable = null): self
    {
        return static::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'auditable_type' => $auditable ? $auditable::class : null,
            'auditable_id' => $auditable ? $auditable->getKey() : null,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 255),
        ]);
    }
}
