<?php

namespace App\Livewire;

use App\Models\Routine;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();

        $routines = Routine::query()
            ->with([
                'days',
                'tasks' => function ($query) {
                    $query
                        ->whereNull('completed_at')
                        ->orderByRaw('day_number IS NULL')
                        ->orderBy('day_number')
                        ->orderBy('id');
                },
            ])
            ->where('active', true)
            ->get()
            ->filter(function (Routine $routine) use ($today) {
                return $routine->days->contains(
                    'day_of_week',
                    $today->dayOfWeekIso
                );
            })
            ->values();

        return view('livewire.dashboard', [
            'today' => $today,
            'routines' => $routines,
            'totalMinutes' => $routines->sum('duration_minutes'),
        ])->layout('layouts.app');
    }
}
