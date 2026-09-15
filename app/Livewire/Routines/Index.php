<?php

namespace App\Livewire\Routines;

use App\Models\Routine;
use Livewire\Component;

class Index extends Component
{
    public bool $showForm = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $category = '';

    public int $duration_minutes = 60;

    public string $priority = 'normal';

    public string $type = 'flexible';

    public bool $active = true;

    public array $selectedDays = [];

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'priority' => ['required', 'in:low,normal,high,critical'],
            'type' => ['required', 'in:fixed,flexible,optional'],
            'active' => ['boolean'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();

        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $routine = Routine::with('days')->findOrFail($id);

        $this->editingId = $routine->id;
        $this->name = $routine->name;
        $this->category = $routine->category ?? '';
        $this->duration_minutes = $routine->duration_minutes;
        $this->priority = $routine->priority;
        $this->type = $routine->type;
        $this->active = $routine->active;

        $this->selectedDays = $routine->days
            ->pluck('day_of_week')
            ->map(fn ($day) => (int) $day)
            ->toArray();

        $this->showForm = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->editingId) {
            $routine = Routine::findOrFail($this->editingId);

            $routine->update($validated);
        } else {
            $routine = Routine::create($validated);
        }

        $routine->days()->delete();

        foreach ($this->selectedDays as $day) {
            $routine->days()->create([
                'day_of_week' => (int) $day,
                'duration_minutes' => $this->duration_minutes,
            ]);
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Routine::findOrFail($id)->delete();
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'showForm',
            'editingId',
            'name',
            'category',
            'duration_minutes',
            'priority',
            'type',
            'active',
            'selectedDays',
        ]);

        $this->duration_minutes = 60;
        $this->priority = 'normal';
        $this->type = 'flexible';
        $this->active = true;
    }

    public function render()
    {
        return view('livewire.routines.index', [
            'routines' => Routine::query()
                ->with('days')
                ->orderBy('name')
                ->get(),
        ])->layout('layouts.app');
    }
}
