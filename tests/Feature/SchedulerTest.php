<?php

namespace Tests\Feature;

use App\Models\Availability;
use App\Models\Event;
use App\Services\Scheduler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchedulerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_entire_availability_when_there_are_no_events(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '22:00',
            'active' => true,
        ]);

        $scheduler = new Scheduler;

        $blocks = $scheduler->getFreeBlocks('2026-08-31');

        $this->assertCount(1, $blocks);

        $this->assertSame('08:00', $blocks[0]['start']);
        $this->assertSame('22:00', $blocks[0]['end']);
        $this->assertSame(840, $blocks[0]['duration_minutes']);
    }

    public function test_it_splits_free_time_around_events(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '22:00',
            'active' => true,
        ]);

        Event::create([
            'title' => 'School',
            'date' => '2026-08-31',
            'start_time' => '09:00',
            'end_time' => '12:00',
            'priority' => 'critical',
        ]);

        Event::create([
            'title' => 'Meeting',
            'date' => '2026-08-31',
            'start_time' => '15:00',
            'end_time' => '16:00',
            'priority' => 'high',
        ]);

        $scheduler = new Scheduler;

        $blocks = $scheduler->getFreeBlocks('2026-08-31');

        $this->assertCount(3, $blocks);

        $this->assertSame('08:00', $blocks[0]['start']);
        $this->assertSame('09:00', $blocks[0]['end']);
        $this->assertSame(60, $blocks[0]['duration_minutes']);

        $this->assertSame('12:00', $blocks[1]['start']);
        $this->assertSame('15:00', $blocks[1]['end']);
        $this->assertSame(180, $blocks[1]['duration_minutes']);

        $this->assertSame('16:00', $blocks[2]['start']);
        $this->assertSame('22:00', $blocks[2]['end']);
        $this->assertSame(360, $blocks[2]['duration_minutes']);
    }

    public function test_it_returns_no_free_time_when_day_is_not_available(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '22:00',
            'active' => false,
        ]);

        $scheduler = new Scheduler;

        $blocks = $scheduler->getFreeBlocks('2026-08-31');

        $this->assertSame([], $blocks);
    }

    public function test_event_outside_availability_does_not_remove_available_time(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '22:00',
            'active' => true,
        ]);

        Event::create([
            'title' => 'Late Event',
            'date' => '2026-08-31',
            'start_time' => '23:00',
            'end_time' => '23:30',
            'priority' => 'normal',
        ]);

        $scheduler = new Scheduler;

        $blocks = $scheduler->getFreeBlocks('2026-08-31');

        $this->assertCount(1, $blocks);

        $this->assertSame('08:00', $blocks[0]['start']);
        $this->assertSame('22:00', $blocks[0]['end']);
    }

    public function test_overlapping_events_are_treated_as_one_unavailable_period(): void
    {
        Availability::create([
            'day_of_week' => 1,
            'start_time' => '08:00',
            'end_time' => '22:00',
            'active' => true,
        ]);

        Event::create([
            'title' => 'School',
            'date' => '2026-08-31',
            'start_time' => '09:00',
            'end_time' => '12:00',
            'priority' => 'critical',
        ]);

        Event::create([
            'title' => 'Meeting',
            'date' => '2026-08-31',
            'start_time' => '11:00',
            'end_time' => '13:00',
            'priority' => 'high',
        ]);

        $scheduler = new Scheduler;

        $blocks = $scheduler->getFreeBlocks('2026-08-31');

        $this->assertCount(2, $blocks);

        $this->assertSame('08:00', $blocks[0]['start']);
        $this->assertSame('09:00', $blocks[0]['end']);

        $this->assertSame('13:00', $blocks[1]['start']);
        $this->assertSame('22:00', $blocks[1]['end']);
    }
}
