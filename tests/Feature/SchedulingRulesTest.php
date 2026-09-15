<?php

namespace Tests\Feature;

use App\Models\Routine;
use App\Services\SchedulingRules;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchedulingRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_routines_are_sorted_by_type_first(): void
    {
        $optional = Routine::create([
            'name' => 'Extra Farming',
            'duration_minutes' => 30,
            'type' => 'optional',
            'priority' => 'critical',
            'active' => true,
        ]);

        $flexible = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        $fixed = Routine::create([
            'name' => 'Morning Study',
            'duration_minutes' => 60,
            'type' => 'fixed',
            'priority' => 'normal',
            'active' => true,
        ]);

        $routines = collect([
            $optional,
            $flexible,
            $fixed,
        ]);

        $rules = new SchedulingRules;

        $sorted = $rules->sortRoutines($routines);

        $this->assertSame(
            [
                'Morning Study',
                'Linux',
                'Extra Farming',
            ],
            $sorted->pluck('name')->all()
        );
    }

    public function test_priority_is_used_when_type_is_the_same(): void
    {
        $normal = Routine::create([
            'name' => 'Language',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => true,
        ]);

        $critical = Routine::create([
            'name' => 'Exam Preparation',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'critical',
            'active' => true,
        ]);

        $high = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        $routines = collect([
            $normal,
            $critical,
            $high,
        ]);

        $rules = new SchedulingRules;

        $sorted = $rules->sortRoutines($routines);

        $this->assertSame(
            [
                'Exam Preparation',
                'Linux',
                'Language',
            ],
            $sorted->pluck('name')->all()
        );
    }

    public function test_same_type_and_priority_are_sorted_by_name(): void
    {
        $linux = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        $capstone = Routine::create([
            'name' => 'Capstone',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        $routines = collect([
            $linux,
            $capstone,
        ]);

        $rules = new SchedulingRules;

        $sorted = $rules->sortRoutines($routines);

        $this->assertSame(
            [
                'Capstone',
                'Linux',
            ],
            $sorted->pluck('name')->all()
        );
    }

    public function test_unknown_type_defaults_to_flexible(): void
    {
        $rules = new SchedulingRules;

        $this->assertSame(
            2,
            $rules->typeValue('unknown')
        );
    }

    public function test_unknown_priority_defaults_to_normal(): void
    {
        $rules = new SchedulingRules;

        $this->assertSame(
            3,
            $rules->priorityValue('unknown')
        );
    }

    public function test_type_values_are_correct(): void
    {
        $rules = new SchedulingRules;

        $this->assertSame(1, $rules->typeValue('fixed'));
        $this->assertSame(2, $rules->typeValue('flexible'));
        $this->assertSame(3, $rules->typeValue('optional'));
    }

    public function test_priority_values_are_correct(): void
    {
        $rules = new SchedulingRules;

        $this->assertSame(1, $rules->priorityValue('critical'));
        $this->assertSame(2, $rules->priorityValue('high'));
        $this->assertSame(3, $rules->priorityValue('normal'));
        $this->assertSame(4, $rules->priorityValue('low'));
    }
}
