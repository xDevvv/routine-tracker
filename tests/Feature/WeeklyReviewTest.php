<?php

namespace Tests\Feature;

use App\Models\FocusSession;
use App\Models\Routine;
use App\Services\WeeklyReviewService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeeklyReviewTest extends TestCase
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

    public function test_it_calculates_weekly_totals(): void
    {
        $routine = $this->createRoutine('Linux');

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => now()->startOfWeek()->addDay()->setTime(8, 0),
            'ended_at' => now()->startOfWeek()->addDay()->setTime(9, 0),
            'planned_minutes' => 60,
            'actual_minutes' => 50,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => now()->startOfWeek()->addDays(2)->setTime(10, 0),
            'ended_at' => now()->startOfWeek()->addDays(2)->setTime(11, 0),
            'planned_minutes' => 60,
            'actual_minutes' => 40,
            'paused_minutes' => 0,
            'status' => 'stopped',
        ]);

        $review = app(WeeklyReviewService::class)->review();

        $this->assertSame(120, $review['planned_minutes']);
        $this->assertSame(90, $review['actual_minutes']);
        $this->assertSame(75, $review['completion_rate']);

        $this->assertSame(1, $review['completed_sessions']);
        $this->assertSame(1, $review['stopped_sessions']);
    }

    public function test_it_returns_seven_days(): void
    {
        $review = app(WeeklyReviewService::class)->review();

        $this->assertCount(7, $review['daily']);
    }

    public function test_it_calculates_daily_breakdown(): void
    {
        $routine = $this->createRoutine('Language');

        $monday = now()
            ->startOfWeek()
            ->setTime(8, 0);

        FocusSession::create([
            'routine_id' => $routine->id,
            'started_at' => $monday,
            'ended_at' => $monday->copy()->addHour(),
            'planned_minutes' => 60,
            'actual_minutes' => 45,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        $review = app(WeeklyReviewService::class)->review();

        $this->assertSame(
            45,
            $review['daily'][0]['actual_minutes']
        );

        $this->assertSame(
            60,
            $review['daily'][0]['planned_minutes']
        );

        $this->assertSame(
            1,
            $review['daily'][0]['sessions']
        );
    }

    public function test_it_groups_sessions_by_routine(): void
    {
        $linux = $this->createRoutine('Linux');
        $language = $this->createRoutine('Language');

        FocusSession::create([
            'routine_id' => $linux->id,
            'started_at' => now()->startOfWeek()->addDay(),
            'ended_at' => now()->startOfWeek()->addDay()->addHour(),
            'planned_minutes' => 60,
            'actual_minutes' => 55,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        FocusSession::create([
            'routine_id' => $linux->id,
            'started_at' => now()->startOfWeek()->addDays(2),
            'ended_at' => now()->startOfWeek()->addDays(2)->addHour(),
            'planned_minutes' => 60,
            'actual_minutes' => 40,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        FocusSession::create([
            'routine_id' => $language->id,
            'started_at' => now()->startOfWeek()->addDays(3),
            'ended_at' => now()->startOfWeek()->addDays(3)->addHour(),
            'planned_minutes' => 60,
            'actual_minutes' => 30,
            'paused_minutes' => 0,
            'status' => 'completed',
        ]);

        $review = app(WeeklyReviewService::class)->review();

        $this->assertCount(2, $review['by_routine']);

        $this->assertSame(
            'Linux',
            $review['by_routine'][0]['routine']->name
        );

        $this->assertSame(
            95,
            $review['by_routine'][0]['actual_minutes']
        );

        $this->assertSame(
            'Language',
            $review['by_routine'][1]['routine']->name
        );

        $this->assertSame(
            30,
            $review['by_routine'][1]['actual_minutes']
        );
    }

    public function test_it_returns_zero_completion_when_nothing_was_planned(): void
    {
        $review = app(WeeklyReviewService::class)->review();

        $this->assertSame(0, $review['planned_minutes']);
        $this->assertSame(0, $review['actual_minutes']);
        $this->assertSame(0, $review['completion_rate']);
    }
}
