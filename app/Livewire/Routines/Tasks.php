<?php

namespace App\Livewire\Routines;

use App\Models\Routine;
use Livewire\Component;

class Tasks extends Component
{
    public Routine $routine;

    public string $title = '';

    public string $description = '';

    public ?int $day_number = null;

    public ?int $estimated_minutes = null;

    public function mount(Routine $routine): void
    {
        $this->routine = $routine;
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'day_number' => ['nullable', 'integer', 'min:1'],
            'estimated_minutes' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function addTask(): void
    {
        $validated = $this->validate();

        $this->routine->tasks()->create($validated);

        $this->reset([
            'title',
            'description',
            'day_number',
            'estimated_minutes',
        ]);
    }

    public function deleteTask(int $taskId): void
    {
        $this->routine
            ->tasks()
            ->findOrFail($taskId)
            ->delete();
    }

    public function toggleComplete(int $taskId): void
    {
        $task = $this->routine
            ->tasks()
            ->findOrFail($taskId);

        $task->update([
            'completed_at' => $task->completed_at
                ? null
                : now(),
        ]);
    }

    public function render()
    {
        return view('livewire.routines.tasks', [
            'tasks' => $this->routine
                ->tasks()
                ->orderByRaw('day_number IS NULL')
                ->orderBy('day_number')
                ->orderBy('id')
                ->get(),
        ])->layout('layouts.app');
    }
}
