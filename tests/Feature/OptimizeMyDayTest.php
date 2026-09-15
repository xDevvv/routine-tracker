<?php

namespace Tests\Feature;

use App\Models\Availability;
use App\Models\Event;
use App\Models\Routine;
use App\Services\DailyScheduler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OptimizeMyDayTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_optimizes_a_day_with_available_time(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '17:00',
            'active' => true,
        ]);

        Event::create([
            'title' => 'School',
            'date' => '2026-08-31',
            'start_time' => '09:00',
            'end_time' => '12:00',
            'priority' => 'critical',
        ]);

        Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Routine::create([
            'name' => 'Language',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => true,
        ]);

        $scheduler = app(DailyScheduler::class);

        $result = $scheduler->optimize(
            '2026-08-31'
        );

        $this->assertFalse(
            $result['has_conflict']
        );

        $this->assertCount(
            2,
            $result['placements']
        );

        $this->assertCount(
            0,
            $result['unscheduled']
        );
    }

    public function test_it_prioritizes_high_priority_routines(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '10:00',
            'active' => true,
        ]);

        Routine::create([
            'name' => 'Language',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => true,
        ]);

        Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Routine::create([
            'name' => 'Capstone',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        $scheduler = app(DailyScheduler::class);

        $result = $scheduler->optimize(
            '2026-08-31'
        );

        $this->assertCount(
            2,
            $result['placements']
        );

        $this->assertCount(
            1,
            $result['unscheduled']
        );

        $this->assertSame(
            'Capstone',
            $result['placements'][0]['routine_name']
        );

        $this->assertSame(
            'Linux',
            $result['placements'][1]['routine_name']
        );

        $this->assertSame(
            'Language',
            $result['unscheduled'][0]->name
        );
    }

    public function test_optional_routines_are_scheduled_last(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '10:00',
            'active' => true,
        ]);

        Routine::create([
            'name' => 'Extra Farming',
            'duration_minutes' => 30,
            'type' => 'optional',
            'priority' => 'critical',
            'active' => true,
        ]);

        Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Routine::create([
            'name' => 'Language',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => true,
        ]);

        $scheduler = app(DailyScheduler::class);

        $result = $scheduler->optimize(
            '2026-08-31'
        );

        $this->assertCount(
            2,
            $result['placements']
        );

        $this->assertCount(
            1,
            $result['unscheduled']
        );

        $this->assertSame(
            'Linux',
            $result['placements'][0]['routine_name']
        );

        $this->assertSame(
            'Language',
            $result['placements'][1]['routine_name']
        );

        $this->assertSame(
            'Extra Farming',
            $result['unscheduled'][0]->name
        );
    }

    public function test_it_provides_a_schedule_summary(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '12:00',
            'active' => true,
        ]);

        Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Routine::create([
            'name' => 'Language',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => true,
        ]);

        $scheduler = app(DailyScheduler::class);

        $result = $scheduler->optimize(
            '2026-08-31'
        );

        $summary = $scheduler->summary($result);

        $this->assertSame(
            240,
            $summary['available_minutes']
        );

        $this->assertSame(
            120,
            $summary['planned_minutes']
        );

        $this->assertSame(
            120,
            $summary['scheduled_minutes']
        );

        $this->assertSame(
            0,
            $summary['unscheduled_minutes']
        );

        $this->assertSame(
            2,
            $summary['scheduled_count']
        );

        $this->assertSame(
            0,
            $summary['unscheduled_count']
        );

        $this->assertFalse(
            $summary['has_conflict']
        );
    }
}
