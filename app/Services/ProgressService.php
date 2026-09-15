<?php

namespace App\Services;

use App\Models\FocusSession;
use Carbon\Carbon;

class ProgressService
{
    public function getToday(): array
    {
        $sessions = FocusSession::query()
            ->whereDate('started_at', today())
            ->whereIn('status', ['completed', 'stopped'])
            ->get();

        return [
            'minutes' => $sessions->sum('actual_minutes'),
            'sessions' => $sessions->count(),
        ];
    }

    public function getThisWeek(): array
    {
        $start = Carbon::now()->startOfWeek();
        $end = Carbon::now()->endOfWeek();

        $sessions = FocusSession::query()
            ->whereBetween('started_at', [$start, $end])
            ->whereIn('status', ['completed', 'stopped'])
            ->get();

        return [
            'minutes' => $sessions->sum('actual_minutes'),
            'sessions' => $sessions->count(),
        ];
    }

    public function getByRoutine()
    {
        return FocusSession::query()
            ->with('routine')
            ->whereIn('status', ['completed', 'stopped'])
            ->get()
            ->groupBy('routine_id')
            ->map(function ($sessions) {
                return [
                    'routine' => $sessions->first()->routine,
                    'minutes' => $sessions->sum('actual_minutes'),
                    'sessions' => $sessions->count(),
                ];
            })
            ->sortByDesc('minutes')
            ->values();
    }

    public function getPlannedVsActual(): array
    {
        $sessions = FocusSession::query()
            ->whereIn('status', ['completed', 'stopped'])
            ->get();

        return [
            'planned' => $sessions->sum('planned_minutes'),
            'actual' => $sessions->sum('actual_minutes'),
        ];
    }
}
