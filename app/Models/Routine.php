<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Routine extends Model
{
    protected $fillable = [
        'name',
        'category',
        'duration_minutes',
        'priority',
        'type',
        'active',
    ];

    public function days(): HasMany
    {
        return $this->hasMany(RoutineDay::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(RoutineTask::class);
    }

    public function focusSessions(): HasMany
    {
        return $this->hasMany(FocusSession::class);
    }
}
