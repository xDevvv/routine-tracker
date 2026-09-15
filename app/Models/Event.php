<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'date',
        'start_time',
        'end_time',
        'location',
        'meeting_link',
        'priority',
        'notes',
        'recurring',
    ];

    protected $casts = [
        'date' => 'date',
        'recurring' => 'boolean',
    ];
}
