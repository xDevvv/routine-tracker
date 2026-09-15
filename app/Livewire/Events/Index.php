<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;

class Index extends Component
{
    public bool $showForm = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $date = '';

    public string $start_time = '';

    public string $end_time = '';

    public string $location = '';

    public string $meeting_link = '';

    public string $priority = 'normal';

    public string $notes = '';

    public bool $recurring = false;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'meeting_link' => ['nullable', 'url', 'max:255'],
            'priority' => ['required', 'in:low,normal,high,critical'],
            'notes' => ['nullable', 'string'],
            'recurring' => ['boolean'],
        ];
    }

    public function create(): void
    {
        $this->resetForm();

        $this->date = now()->format('Y-m-d');

        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $event = Event::findOrFail($id);

        $this->editingId = $event->id;
        $this->title = $event->title;
        $this->date = $event->date->format('Y-m-d');
        $this->start_time = substr($event->start_time, 0, 5);
        $this->end_time = substr($event->end_time, 0, 5);
        $this->location = $event->location ?? '';
        $this->meeting_link = $event->meeting_link ?? '';
        $this->priority = $event->priority;
        $this->notes = $event->notes ?? '';
        $this->recurring = $event->recurring;

        $this->showForm = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->editingId) {
            Event::findOrFail($this->editingId)
                ->update($validated);
        } else {
            Event::create($validated);
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Event::findOrFail($id)->delete();
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
            'title',
            'date',
            'start_time',
            'end_time',
            'location',
            'meeting_link',
            'priority',
            'notes',
            'recurring',
        ]);

        $this->priority = 'normal';
        $this->recurring = false;
    }

    public function render()
    {
        return view('livewire.events.index', [
            'events' => Event::query()
                ->orderBy('date')
                ->orderBy('start_time')
                ->get(),
        ])->layout('layouts.app');
    }
}
