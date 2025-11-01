<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WeeklyPlan extends Model
{
    /** Underlying table */
    protected $table = 'workplans';

    /** Mass-assignable columns (no legacy single-FK columns here) */
    protected $fillable = [
        'updated_on',
        'updated_by',
        'week',
        'start_date',
        'end_date',
        'workplan_desc',
    ];

    /** Date casting */
    protected $casts = [
        'updated_on' => 'date',
        'start_date' => 'date',
        'end_date'   => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* =========================
     * Relationships
     * ========================= */

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'updated_by', 'Emp_ID');
    }

    /** Many-to-many: external platforms */
    public function externalPlatforms(): BelongsToMany
    {
        return $this->belongsToMany(
            ExternalPlatform::class,
            'external_platform_workplan',
            'workplan_id',
            'external_platform_id'
        )->withTimestamps();
    }

    /** Many-to-many: internal platforms */
    public function internalPlatforms(): BelongsToMany
    {
        return $this->belongsToMany(
            InternalPlatform::class,
            'internal_platform_workplan',
            'workplan_id',
            'internal_platform_id'
        )->withTimestamps();
    }

    /* =========================
     * Accessors (helpers for UI)
     * ========================= */

    /** Array of external platform names */
    public function getExternalPlatformNamesAttribute(): array
    {
        return $this->externalPlatforms->pluck('platform_name')->all();
    }

    /** Array of internal platform names */
    public function getInternalPlatformNamesAttribute(): array
    {
        return $this->internalPlatforms->pluck('app_name')->all();
    }

    /** Array of all platform names (external + internal) */
    public function getPlatformNamesAttribute(): array
    {
        return array_values(array_filter(array_merge(
            $this->external_platform_names,
            $this->internal_platform_names
        )));
    }

    /**
     * LEGACY single-string helpers (now comma-separated lists).
     */
    public function getExternalPlatformNameAttribute(): ?string
    {
        $names = $this->external_platform_names;
        return empty($names) ? null : implode(', ', $names);
    }

    public function getInternalPlatformNameAttribute(): ?string
    {
        $names = $this->internal_platform_names;
        return empty($names) ? null : implode(', ', $names);
    }

    /** Unified display string (external + internal, comma-separated) */
    public function getPlatformNameAttribute(): string
    {
        $all = $this->platform_names;
        return empty($all) ? '' : implode(', ', $all);
    }

    /** Tag for UI (“external”, “internal”, “both”, “none”) */
    public function getPlatformTypeAttribute(): string
    {
        $hasExt = $this->externalPlatforms->isNotEmpty();
        $hasInt = $this->internalPlatforms->isNotEmpty();

        if ($hasExt && $hasInt) return 'both';
        if ($hasExt) return 'external';
        if ($hasInt) return 'internal';
        return 'none';
    }

    /* =========================
     * Query scopes
     * ========================= */

    /**
     * scopeSearch: search by platform name (external or internal),
     * employee name/email, or description text.
     *
     * Usage:
     * WeeklyPlan::with(['employee','externalPlatforms','internalPlatforms'])
     *     ->search($q)
     *     ->orderByDesc('start_date')
     *     ->paginate(20);
     */
    public function scopeSearch($query, ?string $q)
    {
        $q = trim((string) $q);
        if ($q === '') return $query;

        return $query->where(function ($w) use ($q) {
            $w->whereHas('externalPlatforms', function ($q2) use ($q) {
                    $q2->where('platform_name', 'like', "%{$q}%");
                })
              ->orWhereHas('internalPlatforms', function ($q3) use ($q) {
                    $q3->where('app_name', 'like', "%{$q}%");
                })
              ->orWhereHas('employee', function ($q4) use ($q) {
                    $q4->where('emp_name', 'like', "%{$q}%")
                       ->orWhere('emp_email', 'like', "%{$q}%");
                })
              ->orWhere('workplan_desc', 'like', "%{$q}%");
        });
    }
}
