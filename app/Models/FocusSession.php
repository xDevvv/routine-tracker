<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FocusSession extends Model
{
    protected $fillable = [
        'routine_id',
        'started_at',
        'ended_at',
        'planned_minutes',
        'actual_minutes',
        'status',
        'paused_at',
        'paused_minutes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'paused_at' => 'datetime',
        'planned_minutes' => 'integer',
        'actual_minutes' => 'integer',
        'paused_minutes' => 'integer',
    ];

    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class);
    }
}
