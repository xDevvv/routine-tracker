<?php

namespace Tests\Feature;

use App\Models\Routine;
use App\Services\ConflictDetector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConflictDetectorTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_reports_no_conflict_when_routines_fit(): void
    {
        $routines = collect([
            Routine::make([
                'name' => 'Linux',
                'duration_minutes' => 60,
            ]),
            Routine::make([
                'name' => 'Language',
                'duration_minutes' => 60,
            ]),
            Routine::make([
                'name' => 'Capstone',
                'duration_minutes' => 60,
            ]),
        ]);

        $detector = new ConflictDetector;

        $result = $detector->check($routines, 240);

        $this->assertSame(240, $result['available_minutes']);
        $this->assertSame(180, $result['planned_minutes']);
        $this->assertSame(0, $result['conflict_minutes']);
        $this->assertFalse($result['has_conflict']);
    }

    public function test_it_detects_when_routines_exceed_available_time(): void
    {
        $routines = collect([
            Routine::make([
                'name' => 'Linux',
                'duration_minutes' => 60,
            ]),
            Routine::make([
                'name' => 'Capstone',
                'duration_minutes' => 60,
            ]),
            Routine::make([
                'name' => 'MIR4',
                'duration_minutes' => 120,
            ]),
        ]);

        $detector = new ConflictDetector;

        $result = $detector->check($routines, 180);

        $this->assertSame(180, $result['available_minutes']);
        $this->assertSame(240, $result['planned_minutes']);
        $this->assertSame(60, $result['conflict_minutes']);
        $this->assertTrue($result['has_conflict']);
    }

    public function test_it_reports_no_conflict_when_time_matches_exactly(): void
    {
        $routines = collect([
            Routine::make([
                'name' => 'Linux',
                'duration_minutes' => 60,
            ]),
            Routine::make([
                'name' => 'Running',
                'duration_minutes' => 45,
            ]),
        ]);

        $detector = new ConflictDetector;

        $result = $detector->check($routines, 105);

        $this->assertSame(105, $result['available_minutes']);
        $this->assertSame(105, $result['planned_minutes']);
        $this->assertSame(0, $result['conflict_minutes']);
        $this->assertFalse($result['has_conflict']);
    }

    public function test_it_handles_zero_available_time(): void
    {
        $routines = collect([
            Routine::make([
                'name' => 'Linux',
                'duration_minutes' => 60,
            ]),
        ]);

        $detector = new ConflictDetector;

        $result = $detector->check($routines, 0);

        $this->assertSame(0, $result['available_minutes']);
        $this->assertSame(60, $result['planned_minutes']);
        $this->assertSame(60, $result['conflict_minutes']);
        $this->assertTrue($result['has_conflict']);
    }

    public function test_it_handles_no_routines(): void
    {
        $detector = new ConflictDetector;

        $result = $detector->check(collect(), 300);

        $this->assertSame(300, $result['available_minutes']);
        $this->assertSame(0, $result['planned_minutes']);
        $this->assertSame(0, $result['conflict_minutes']);
        $this->assertFalse($result['has_conflict']);
    }
}
