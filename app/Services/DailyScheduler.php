<?php

namespace App\Services;

use App\Models\Routine;

class DailyScheduler
{
    public function __construct(
        private Scheduler $scheduler,
        private SchedulingRules $rules,
        private ConflictDetector $conflictDetector,
        private RoutinePlacer $placer,
    ) {}

    public function optimize(string $date): array
    {
        // Get available blocks after fixed events.
        $freeBlocks = $this->scheduler->getFreeBlocks($date);

        // Only active routines participate.
        $routines = Routine::query()
            ->where('active', true)
            ->get();

        // Apply scheduling rules.
        $orderedRoutines = $this->rules
            ->sortRoutines($routines);

        // Calculate total available time.
        $availableMinutes = collect($freeBlocks)
            ->sum(
                fn ($block) => (int) $block['duration_minutes']
            );

        // Check whether everything fits.
        $conflict = $this->conflictDetector->check(
            $orderedRoutines,
            $availableMinutes
        );

        // Place routines into available blocks.
        $placement = $this->placer->place(
            $orderedRoutines,
            $freeBlocks
        );

        return [
            'date' => $date,

            'free_blocks' => $freeBlocks,

            'available_minutes' => $availableMinutes,

            'planned_minutes' => $conflict['planned_minutes'],

            'conflict_minutes' => $conflict['conflict_minutes'],

            'has_conflict' => $conflict['has_conflict'],

            // Complete conflict information.
            'conflict' => $conflict,

            'placements' => $placement['placements'],

            'unscheduled' => $placement['unscheduled'],
        ];
    }

    public function summary(array $schedule): array
    {
        return [
            'available_minutes' => $schedule['available_minutes'],

            'planned_minutes' => $schedule['planned_minutes'],

            'scheduled_minutes' => collect($schedule['placements'])
                ->sum('duration_minutes'),

            'unscheduled_minutes' => collect($schedule['unscheduled'])
                ->sum('duration_minutes'),

            'scheduled_count' => count($schedule['placements']),

            'unscheduled_count' => count($schedule['unscheduled']),

            'has_conflict' => $schedule['has_conflict'],
        ];
    }
}
