<?php

namespace Tests\Feature;

use App\Models\FocusSession;
use App\Models\Routine;
use App\Services\ProgressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgressTest extends TestCase
{
    use RefreshDatabase;

    private function createRoutine(string $name): Routine
    {
        return Routine::create([
            'name' => $name,
            'description' => $name.' routine',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => true,
        ]);
    }

    public function test_it_calculates_today_progress(): void
    {
        $routine = $this->createRoutine('Linux');

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => now()->startOfDay()->addHours(8),
            'ended_at' => now()->startOfDay()->addHours(9),
            'planned_minutes' => 60,
            'actual_minutes' => 50,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => now()->startOfDay()->addHours(10),
            'ended_at' => now()->startOfDay()->addHours(11),
            'planned_minutes' => 60,
            'actual_minutes' => 40,
            'paused_minutes' => 0,
            'status' => 'stopped',
        ]);

        $progress = app(ProgressService::class)->getToday();

        $this->assertSame(90, $progress['minutes']);
        $this->assertSame(2, $progress['sessions']);
    }

    public function test_it_calculates_this_week_progress(): void
    {
        $routine = $this->createRoutine('Language');

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => now()->startOfWeek()->addDay(),
            'ended_at' => now()->startOfWeek()->addDay()->addHour(),
            'planned_minutes' => 60,
            'actual_minutes' => 55,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        $progress = app(ProgressService::class)->getThisWeek();

        $this->assertSame(55, $progress['minutes']);
        $this->assertSame(1, $progress['sessions']);
    }

    public function test_it_groups_progress_by_routine(): void
    {
        $linux = $this->createRoutine('Linux');
        $language = $this->createRoutine('Language');

        FocusSession::create([
            'routine_id' => $linux->id,
            'started_at' => now()->subDay(),
            'ended_at' => now()->subDay()->addHour(),
            'planned_minutes' => 60,
            'actual_minutes' => 60,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        FocusSession::create([
            'routine_id' => $linux->id,
            'started_at' => now(),
            'ended_at' => now()->addHour(),
            'planned_minutes' => 60,
            'actual_minutes' => 45,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        FocusSession::create([
            'routine_id' => $language->id,
            'started_at' => now(),
            'ended_at' => now()->addHour(),
            'planned_minutes' => 60,
            'actual_minutes' => 30,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        $progress = app(ProgressService::class)->getByRoutine();

        $this->assertCount(2, $progress);

        $this->assertSame('Linux', $progress[0]['routine']->name);
        $this->assertSame(105, $progress[0]['minutes']);

        $this->assertSame('Language', $progress[1]['routine']->name);
        $this->assertSame(30, $progress[1]['minutes']);
    }

    public function test_it_calculates_planned_vs_actual(): void
    {
        $routine = $this->createRoutine('Capstone');

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => now()->subHour(),
            'ended_at' => now(),
            'planned_minutes' => 60,
            'actual_minutes' => 45,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        $progress = app(ProgressService::class)
            ->getPlannedVsActual();

        $this->assertSame(60, $progress['planned']);
        $this->assertSame(45, $progress['actual']);
    }
}
