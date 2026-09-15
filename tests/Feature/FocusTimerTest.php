<?php

namespace Tests\Feature;

use App\Livewire\Focus\Timer;
use App\Models\Routine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FocusTimerTest extends TestCase
{
    use RefreshDatabase;

    public function test_timer_can_start(): void
    {
        $routine = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Livewire::test(Timer::class)
            ->set('routineId', $routine->id)
            ->set('durationMinutes', 25)
            ->call('start')
            ->assertSet('running', true)
            ->assertSet('paused', false)
            ->assertSet('remainingSeconds', 1500);
    }

    public function test_timer_can_pause(): void
    {
        $routine = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Livewire::test(Timer::class)
            ->set('routineId', $routine->id)
            ->set('durationMinutes', 25)
            ->call('start')
            ->call('pause')
            ->assertSet('running', false)
            ->assertSet('paused', true);
    }

    public function test_timer_can_resume(): void
    {
        $routine = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Livewire::test(Timer::class)
            ->set('routineId', $routine->id)
            ->set('durationMinutes', 25)
            ->call('start')
            ->call('pause')
            ->call('resume')
            ->assertSet('running', true)
            ->assertSet('paused', false);
    }

    public function test_timer_can_stop(): void
    {
        $routine = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Livewire::test(Timer::class)
            ->set('routineId', $routine->id)
            ->set('durationMinutes', 25)
            ->call('start')
            ->call('stop')
            ->assertSet('running', false)
            ->assertSet('paused', false)
            ->assertSet('remainingSeconds', 0);
    }

    public function test_timer_tick_decreases_remaining_time(): void
    {
        $routine = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Livewire::test(Timer::class)
            ->set('routineId', $routine->id)
            ->set('durationMinutes', 25)
            ->call('start')
            ->call('tick')
            ->assertSet('remainingSeconds', 1499);
    }

    public function test_timer_stops_when_time_reaches_zero(): void
    {
        $routine = Routine::create([
            'name' => 'Linux',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'high',
            'active' => true,
        ]);

        Livewire::test(Timer::class)
            ->set('routineId', $routine->id)
            ->set('remainingSeconds', 1)
            ->set('running', true)
            ->call('tick')
            ->assertSet('remainingSeconds', 0)
            ->assertSet('running', false)
            ->assertSet('paused', false);
    }

    public function test_inactive_routines_are_not_available(): void
    {
        Routine::create([
            'name' => 'Inactive Routine',
            'duration_minutes' => 60,
            'type' => 'flexible',
            'priority' => 'normal',
            'active' => false,
        ]);

        Livewire::test(Timer::class)
            ->assertDontSee('Inactive Routine');
    }
}
