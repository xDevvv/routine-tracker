<?php

namespace App\Livewire\Focus;

use App\Models\FocusSession;
use App\Models\Routine;
use App\Services\TimeTracker;
use Livewire\Component;

class Timer extends Component
{
    public ?int $routineId = null;

    public int $durationMinutes = 25;

    public int $remainingSeconds = 0;

    public bool $running = false;

    public bool $paused = false;

    public ?int $sessionId = null;

    public function start(): void
    {
        if (! $this->routineId) {
            return;
        }

        if ($this->remainingSeconds <= 0) {
            $this->remainingSeconds =
                $this->durationMinutes * 60;
        }

        $routine = Routine::find($this->routineId);

        if (! $routine) {
            return;
        }

        $session = app(TimeTracker::class)->start(
            $routine,
            $this->durationMinutes
        );

        $this->sessionId = $session->id;

        $this->running = true;
        $this->paused = false;
    }

    public function pause(): void
    {
        if (! $this->running || ! $this->sessionId) {
            return;
        }

        $session = FocusSession::find(
            $this->sessionId
        );

        if ($session) {
            app(TimeTracker::class)->pause($session);
        }

        $this->running = false;
        $this->paused = true;
    }

    public function resume(): void
    {
        if (! $this->paused || ! $this->sessionId) {
            return;
        }

        $session = FocusSession::find(
            $this->sessionId
        );

        if ($session) {
            app(TimeTracker::class)->resume($session);
        }

        $this->running = true;
        $this->paused = false;
    }

    public function stop(): void
    {
        if ($this->sessionId) {
            $session = FocusSession::find(
                $this->sessionId
            );

            if ($session) {
                app(TimeTracker::class)->stop($session);
            }
        }

        $this->sessionId = null;

        $this->running = false;
        $this->paused = false;
        $this->remainingSeconds = 0;
    }

    public function resetTimer(): void
    {
        $this->running = false;
        $this->paused = false;
        $this->remainingSeconds = $this->durationMinutes * 60;
    }

    public function tick(): void
    {
        if (! $this->running) {
            return;
        }

        if ($this->remainingSeconds > 0) {
            $this->remainingSeconds--;
        }

        if ($this->remainingSeconds <= 0) {
            $this->completeSession();
        }
    }

    public function completeSession(): void
    {
        if ($this->sessionId) {
            $session = FocusSession::find(
                $this->sessionId
            );

            if ($session) {
                app(TimeTracker::class)
                    ->complete($session);
            }
        }

        $this->sessionId = null;

        $this->running = false;
        $this->paused = false;
        $this->remainingSeconds = 0;

        $this->dispatch('timer-completed');
    }

    public function updatedDurationMinutes(): void
    {
        if (! $this->running) {
            $this->remainingSeconds = $this->durationMinutes * 60;
        }
    }

    public function updatedRoutineId(): void
    {
        if (! $this->running) {
            $this->remainingSeconds = $this->durationMinutes * 60;
        }
    }

    public function render()
    {
        return view('livewire.focus.timer', [
            'routines' => Routine::query()
                ->where('active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }
}
