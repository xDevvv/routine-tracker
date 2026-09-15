<?php

namespace Tests\Feature;

use App\Models\FocusSession;
use App\Models\Routine;
use App\Services\TimeTracker;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_running_session(): void
    {
        $routine = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        $session = app(TimeTracker::class)->start(
            $routine,
            60
        );

        $this->assertInstanceOf(
            FocusSession::class,
            $session
        );

        $this->assertSame(
            $routine->id,
            $session->routine_id
        );

        $this->assertSame(
            60,
            $session->planned_minutes
        );

        $this->assertSame(
            0,
            $session->actual_minutes
        );

        $this->assertSame(
            'running',
            $session->status
        );

        $this->assertNull(
            $session->ended_at
        );
    }

    public function test_it_completes_a_session(): void
    {
        $routine = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Carbon::setTestNow(
            Carbon::parse('2026-08-28 20:00:00')
        );

        $session = app(TimeTracker::class)->start(
            $routine,
            60
        );

        Carbon::setTestNow(
            Carbon::parse('2026-08-28 20:45:00')
        );

        $session = app(TimeTracker::class)
            ->complete($session);

        $this->assertSame(
            'completed',
            $session->status
        );

        $this->assertSame(
            45,
            $session->actual_minutes
        );

        $this->assertNotNull(
            $session->ended_at
        );

        Carbon::setTestNow();
    }

    public function test_it_stops_a_session(): void
    {
        $routine = Routine::create([
            'name' => 'Language',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => true,
        ]);

        Carbon::setTestNow(
            Carbon::parse('2026-08-28 20:00:00')
        );

        $session = app(TimeTracker::class)->start(
            $routine,
            60
        );

        Carbon::setTestNow(
            Carbon::parse('2026-08-28 20:20:00')
        );

        $session = app(TimeTracker::class)
            ->stop($session);

        $this->assertSame(
            'stopped',
            $session->status
        );

        $this->assertSame(
            20,
            $session->actual_minutes
        );

        Carbon::setTestNow();
    }

    public function test_paused_time_is_not_counted(): void
    {
        $routine = Routine::create([
            'name' => 'Capstone',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Carbon::setTestNow(
            Carbon::parse('2026-08-28 20:00:00')
        );

        $session = app(TimeTracker::class)->start(
            $routine,
            60
        );

        Carbon::setTestNow(
            Carbon::parse('2026-08-28 20:20:00')
        );

        $session = app(TimeTracker::class)
            ->pause($session);

        Carbon::setTestNow(
            Carbon::parse('2026-08-28 20:30:00')
        );

        $session = app(TimeTracker::class)
            ->resume($session);

        Carbon::setTestNow(
            Carbon::parse('2026-08-28 20:50:00')
        );

        $session = app(TimeTracker::class)
            ->complete($session);

        $this->assertSame(
            40,
            $session->actual_minutes
        );

        $this->assertSame(
            10,
            $session->paused_minutes
        );

        Carbon::setTestNow();
    }
}
