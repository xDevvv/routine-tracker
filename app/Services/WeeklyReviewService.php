<?php

namespace App\Services;

use App\Models\FocusSession;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class WeeklyReviewService
{
    public function review(?string $week = null): array
    {
        $date = $week
            ? Carbon::parse($week)
            : now();

        $start = $date->copy()->startOfWeek();
        $end = $date->copy()->endOfWeek();

        $sessions = FocusSession::query()
            ->with('routine')
            ->whereBetween('started_at', [$start, $end])
            ->whereIn('status', ['completed', 'stopped'])
            ->get();

        $planned = (int) $sessions->sum('planned_minutes');
        $actual = (int) $sessions->sum('actual_minutes');

        return [
            'week_start' => $start,
            'week_end' => $end,

            'planned_minutes' => $planned,

            'actual_minutes' => $actual,

            'completion_rate' => $planned > 0
                ? (int) round(($actual / $planned) * 100)
                : 0,

            'completed_sessions' => $sessions
                ->where('status', 'completed')
                ->count(),

            'stopped_sessions' => $sessions
                ->where('status', 'stopped')
                ->count(),

            'daily' => $this->dailyBreakdown($sessions, $start),

            'by_routine' => $this->routineBreakdown($sessions),
        ];
    }

    private function dailyBreakdown($sessions, CarbonInterface $start): array
    {
        $days = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $start->copy()->addDays($i);

            $daySessions = $sessions->filter(function ($session) use ($date) {
                return $session->started_at->isSameDay($date);
            });

            $days[] = [
                'date' => $date->copy(),

                'planned_minutes' => (int) $daySessions
                    ->sum('planned_minutes'),

                'actual_minutes' => (int) $daySessions
                    ->sum('actual_minutes'),

                'sessions' => $daySessions->count(),
            ];
        }

        return $days;
    }

    private function routineBreakdown($sessions)
    {
        return $sessions
            ->groupBy('routine_id')
            ->map(function ($routineSessions) {
                return [
                    'routine' => $routineSessions->first()->routine,

                    'planned_minutes' => (int) $routineSessions
                        ->sum('planned_minutes'),

                    'actual_minutes' => (int) $routineSessions
                        ->sum('actual_minutes'),

                    'sessions' => $routineSessions->count(),
                ];
            })
            ->sortByDesc('actual_minutes')
            ->values();
    }
}
