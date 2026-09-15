<?php

namespace Tests\Feature;

use App\Models\Availability;
use App\Models\Event;
use App\Models\Routine;
use App\Services\DailyScheduler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DailySchedulerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_builds_a_daily_schedule_around_fixed_events(): void
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

        $result = $scheduler->optimize('2026-08-31');

        $this->assertSame(
            '2026-08-31',
            $result['date']
        );

        $this->assertCount(
            2,
            $result['placements']
        );

        $this->assertSame(
            'Linux',
            $result['placements'][0]['routine_name']
        );

        $this->assertSame(
            '08:00',
            $result['placements'][0]['start']
        );

        $this->assertSame(
            '09:00',
            $result['placements'][0]['end']
        );

        $this->assertSame(
            'Language',
            $result['placements'][1]['routine_name']
        );

        $this->assertSame(
            '12:00',
            $result['placements'][1]['start']
        );

        $this->assertSame(
            '13:00',
            $result['placements'][1]['end']
        );
    }

    public function test_it_reports_unscheduled_routines_when_the_day_is_full(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '10:00',
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

        Routine::create([
            'name' => 'Language',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => true,
        ]);

        $scheduler = app(DailyScheduler::class);

        $result = $scheduler->optimize('2026-08-31');

        $this->assertCount(
            2,
            $result['placements']
        );

        $this->assertCount(
            1,
            $result['unscheduled']
        );

        $this->assertSame(
            'Language',
            $result['unscheduled'][0]->name
        );

        $this->assertTrue(
            $result['conflict']['has_conflict']
        );
    }

    public function test_it_ignores_inactive_routines(): void
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
            'name' => 'Disabled Routine',
            'duration_minutes' => 120,
            'type' => 'flexible',
            'priority' => 'critical',
            'active' => false,
        ]);

        $scheduler = app(DailyScheduler::class);

        $result = $scheduler->optimize('2026-08-31');

        $this->assertCount(
            1,
            $result['placements']
        );

        $this->assertSame(
            'Linux',
            $result['placements'][0]['routine_name']
        );
    }
}
