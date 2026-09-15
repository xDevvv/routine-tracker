<?php

namespace App\Livewire\History;

use App\Models\Routine;
use App\Services\TimeTracker;
use Livewire\Component;

class Index extends Component
{
    public ?int $routineId = null;

    public function render(TimeTracker $timeTracker)
    {
        return view('livewire.history.index', [
            'sessions' => $timeTracker->history($this->routineId),
            'routines' => Routine::query()
                ->where('active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }
}
