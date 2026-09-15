<?php

namespace App\Services;

use Illuminate\Support\Collection;

class RoutinePlacer
{
    public function place(
        Collection $routines,
        array $freeBlocks
    ): array {
        $placements = [];
        $placedRoutineIds = [];

        foreach ($freeBlocks as $block) {
            $currentTime = $block['start'];
            $remainingMinutes = (int) $block['duration_minutes'];

            foreach ($routines as $routine) {
                if (in_array($routine->id, $placedRoutineIds, true)) {
                    continue;
                }

                $duration = (int) $routine->duration_minutes;

                if ($duration > $remainingMinutes) {
                    continue;
                }

                $endTime = $this->addMinutes(
                    $currentTime,
                    $duration
                );

                $placements[] = [
                    'routine_id' => $routine->id,
                    'routine_name' => $routine->name,
                    'type' => $routine->type,
                    'priority' => $routine->priority,
                    'start' => $currentTime,
                    'end' => $endTime,
                    'duration_minutes' => $duration,
                ];

                $placedRoutineIds[] = $routine->id;

                $currentTime = $endTime;
                $remainingMinutes -= $duration;
            }
        }

        $unscheduled = $routines
            ->reject(
                fn ($routine) => in_array(
                    $routine->id,
                    $placedRoutineIds,
                    true
                )
            )
            ->values();

        return [
            'placements' => $placements,
            'unscheduled' => $unscheduled,
        ];
    }

    private function addMinutes(
        string $time,
        int $minutes
    ): string {
        return date(
            'H:i',
            strtotime($time) + ($minutes * 60)
        );
    }
}
