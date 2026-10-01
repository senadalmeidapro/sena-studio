<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\EngagementPricingModel;
use App\Enums\EngagementStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Engagement extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'project_id', 'title', 'scope', 'pricing_model', 'amount', 'currency', 'status', 'started_at', 'ended_at'];

    protected function casts(): array
    {
        return ['amount' => 'integer', 'currency' => Currency::class, 'pricing_model' => EngagementPricingModel::class, 'status' => EngagementStatus::class, 'started_at' => 'date', 'ended_at' => 'date'];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function deliverables(): HasMany
    {
        return $this->hasMany(Deliverable::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
