<?php

namespace App\Services;

use App\Models\Availability;
use App\Models\Event;
use Carbon\Carbon;

class Scheduler
{
    /**
     * Get the free time blocks for a specific date.
     */
    public function getFreeBlocks(string $date): array
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeekIso;

        $availability = Availability::query()
            ->where('day_of_week', $dayOfWeek)
            ->where('active', true)
            ->first();

        if (! $availability) {
            return [];
        }

        $start = Carbon::parse(
            "{$date} {$availability->start_time}"
        );

        $end = Carbon::parse(
            "{$date} {$availability->end_time}"
        );

        $events = Event::query()
            ->whereDate('date', $date)
            ->orderBy('start_time')
            ->get();

        $freeBlocks = [];

        $current = $start->copy();

        foreach ($events as $event) {
            $eventStart = Carbon::parse(
                "{$date} {$event->start_time}"
            );

            $eventEnd = Carbon::parse(
                "{$date} {$event->end_time}"
            );

            // Ignore events outside the availability window.
            if ($eventEnd->lte($start) || $eventStart->gte($end)) {
                continue;
            }

            // Keep the event inside the availability window.
            $eventStart = $eventStart->max($start);
            $eventEnd = $eventEnd->min($end);

            // There is free time before this event.
            if ($eventStart->gt($current)) {
                $freeBlocks[] = [
                    'start' => $current->format('H:i'),
                    'end' => $eventStart->format('H:i'),
                    'duration_minutes' => (int) $current->diffInMinutes($eventStart),
                ];
            }

            // Move current position past the event.
            if ($eventEnd->gt($current)) {
                $current = $eventEnd->copy();
            }
        }

        // Free time after the last event.
        if ($current->lt($end)) {
            $freeBlocks[] = [
                'start' => $current->format('H:i'),
                'end' => $end->format('H:i'),
                'duration_minutes' => (int) $current->diffInMinutes($end),
            ];
        }

        return $freeBlocks;
    }
}
