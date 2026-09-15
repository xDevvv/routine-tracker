<?php

namespace App\Services;

use App\Models\FocusSession;
use App\Models\Routine;
use Carbon\CarbonInterface;

class TimeTracker
{
    public function start(
        Routine $routine,
        int $plannedMinutes
    ): FocusSession {
        return FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => now(),
            'planned_minutes' => $plannedMinutes,
            'actual_minutes' => 0,
            'paused_minutes' => 0,
            'status' => 'running',
        ]);
    }

    public function pause(
        FocusSession $session
    ): FocusSession {
        $session->update([
            'paused_at' => now(),
        ]);

        return $session->fresh();
    }

    public function resume(
        FocusSession $session
    ): FocusSession {
        if (! $session->paused_at) {
            return $session;
        }

        $pausedAt = $session->paused_at;

        $pausedMinutes = (int) floor(
            $pausedAt->diffInSeconds(now()) / 60
        );

        $session->update([
            'paused_minutes' => $session->paused_minutes + $pausedMinutes,

            'paused_at' => null,
        ]);

        return $session->fresh();
    }

    public function complete(
        FocusSession $session
    ): FocusSession {
        return $this->finish(
            $session,
            'completed'
        );
    }

    public function stop(
        FocusSession $session
    ): FocusSession {
        return $this->finish(
            $session,
            'stopped'
        );
    }

    private function finish(
        FocusSession $session,
        string $status
    ): FocusSession {
        $endedAt = now();

        $pausedMinutes = $session->paused_minutes ?? 0;

        if ($session->paused_at) {
            $pausedMinutes += (int) floor(
                $session->paused_at->diffInSeconds($endedAt) / 60
            );
        }

        $totalMinutes = $this->calculateMinutes(
            $session->started_at,
            $endedAt
        );

        $actualMinutes = max(
            0,
            $totalMinutes - $pausedMinutes
        );

        $session->update([
            'ended_at' => $endedAt,
            'actual_minutes' => $actualMinutes,
            'paused_minutes' => $pausedMinutes,
            'paused_at' => null,
            'status' => $status,
        ]);

        return $session->fresh();
    }

    private function calculateMinutes(
        CarbonInterface $startedAt,
        CarbonInterface $endedAt
    ): int {
        return (int) floor(
            $startedAt->diffInSeconds($endedAt) / 60
        );
    }

    public function history(?int $routineId = null)
    {
        return FocusSession::query()
            ->with('routine')
            ->when(
                $routineId,
                fn ($query) => $query->where('routine_id', $routineId)
            )
            ->whereIn('status', ['completed', 'stopped'])
            ->latest('started_at')
            ->get();
    }
}
