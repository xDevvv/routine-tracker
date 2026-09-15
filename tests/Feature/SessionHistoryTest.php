<?php

namespace Tests\Feature;

use App\Models\FocusSession;
use App\Models\Routine;
use App\Services\TimeTracker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_completed_and_stopped_sessions(): void
    {
        $routine = Routine::create([
            'name' => 'Linux',
            'description' => 'Linux practice',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => '2026-08-28 08:00:00',
            'ended_at' => '2026-08-28 09:00:00',
            'planned_minutes' => 60,
            'actual_minutes' => 60,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => '2026-08-27 08:00:00',
            'ended_at' => '2026-08-27 08:30:00',
            'planned_minutes' => 60,
            'actual_minutes' => 30,
            'paused_minutes' => 0,
            'status' => 'stopped',
        ]);

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => '2026-08-26 08:00:00',
            'planned_minutes' => 60,
            'actual_minutes' => 0,
            'paused_minutes' => 0,
            'status' => 'running',
        ]);

        $history = app(TimeTracker::class)->history();

        $this->assertCount(2, $history);

        $this->assertSame(
            'completed',
            $history[0]->status
        );

        $this->assertSame(
            'stopped',
            $history[1]->status
        );
    }

    public function test_it_can_filter_history_by_routine(): void
    {
        $linux = Routine::create([
            'name' => 'Linux',
            'description' => 'Linux practice',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        $language = Routine::create([
            'name' => 'Language',
            'description' => 'Language learning',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => true,
        ]);

        FocusSession::create([
            'routine_id' => $linux->id,
            'started_at' => '2026-08-28 08:00:00',
            'ended_at' => '2026-08-28 09:00:00',
            'planned_minutes' => 60,
            'actual_minutes' => 60,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        FocusSession::create([
            'routine_id' => $language->id,
            'started_at' => '2026-08-28 10:00:00',
            'ended_at' => '2026-08-28 11:00:00',
            'planned_minutes' => 60,
            'actual_minutes' => 60,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        $history = app(TimeTracker::class)
            ->history($linux->id);

        $this->assertCount(1, $history);

        $this->assertSame(
            'Linux',
            $history[0]->routine->name
        );
    }
}
