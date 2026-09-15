<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ConflictDetector
{
    /**
     * Check whether routines fit within the available minutes.
     */
    public function check(
        Collection $routines,
        int $availableMinutes
    ): array {
        $totalMinutes = $routines->sum(
            fn ($routine) => (int) $routine->duration_minutes
        );

        $conflictMinutes = max(
            0,
            $totalMinutes - $availableMinutes
        );

        return [
            'available_minutes' => $availableMinutes,
            'planned_minutes' => $totalMinutes,
            'conflict_minutes' => $conflictMinutes,
            'has_conflict' => $conflictMinutes > 0,
        ];
    }
}
