<?php

namespace App\Services;

use Illuminate\Support\Collection;

class SchedulingRules
{
    private const PRIORITIES = [
        'critical' => 1,
        'high' => 2,
        'normal' => 3,
        'low' => 4,
    ];

    private const TYPES = [
        'fixed' => 1,
        'flexible' => 2,
        'optional' => 3,
    ];

    public function sortRoutines(Collection $routines): Collection
    {
        return $routines
            ->sort(function ($a, $b) {
                $typeA = $this->typeValue($a->type);
                $typeB = $this->typeValue($b->type);

                if ($typeA !== $typeB) {
                    return $typeA <=> $typeB;
                }

                $priorityA = $this->priorityValue($a->priority);
                $priorityB = $this->priorityValue($b->priority);

                if ($priorityA !== $priorityB) {
                    return $priorityA <=> $priorityB;
                }

                return strcasecmp(
                    $a->name,
                    $b->name
                );
            })
            ->values();
    }

    public function typeValue(string $type): int
    {
        return self::TYPES[$type] ?? 2;
    }

    public function priorityValue(string $priority): int
    {
        return self::PRIORITIES[$priority] ?? 3;
    }
}
