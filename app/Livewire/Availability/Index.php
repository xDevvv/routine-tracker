<?php

namespace App\Livewire\Availability;

use App\Models\Availability;
use Livewire\Component;

class Index extends Component
{
    public array $days = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday',
    ];

    public array $availability = [];

    public function mount(): void
    {
        foreach ($this->days as $day => $name) {
            $existing = Availability::where('day_of_week', $day)->first();

            $this->availability[$day] = [
                'active' => $existing?->active ?? true,
                'start_time' => $existing
                    ? substr($existing->start_time, 0, 5)
                    : '07:00',
                'end_time' => $existing
                    ? substr($existing->end_time, 0, 5)
                    : '22:00',
            ];
        }
    }

    public function save(): void
    {
        foreach ($this->days as $day => $name) {
            Availability::updateOrCreate(
                ['day_of_week' => $day],
                [
                    'active' => $this->availability[$day]['active'],
                    'start_time' => $this->availability[$day]['start_time'],
                    'end_time' => $this->availability[$day]['end_time'],
                ]
            );
        }

        session()->flash('success', 'Availability saved.');
    }

    public function render()
    {
        return view('livewire.availability.index')
            ->layout('layouts.app');
    }
}
