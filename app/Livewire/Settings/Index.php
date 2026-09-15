<?php

namespace App\Livewire\Settings;

use App\Services\SettingsService;
use Livewire\Component;

class Index extends Component
{
    public string $dayStart = '08:00';

    public string $dayEnd = '22:00';

    public int $minimumBlockMinutes = 15;

    public bool $autoSchedule = true;

    public string $message = '';

    public function mount(SettingsService $settings): void
    {
        $data = $settings->all();

        $this->dayStart = $data['day_start'];
        $this->dayEnd = $data['day_end'];
        $this->minimumBlockMinutes = $data['minimum_block_minutes'];
        $this->autoSchedule = $data['auto_schedule'];
    }

    public function save(SettingsService $settings): void
    {
        $this->validate([
            'dayStart' => [
                'required',
                'date_format:H:i',
            ],

            'dayEnd' => [
                'required',
                'date_format:H:i',
            ],

            'minimumBlockMinutes' => [
                'required',
                'integer',
                'min:5',
                'max:120',
            ],
        ]);

        $settings->set('day_start', $this->dayStart);
        $settings->set('day_end', $this->dayEnd);
        $settings->set(
            'minimum_block_minutes',
            $this->minimumBlockMinutes
        );
        $settings->set(
            'auto_schedule',
            $this->autoSchedule ? '1' : '0'
        );

        $this->message = 'Settings saved successfully.';
    }

    public function render()
    {
        return view('livewire.settings.index');
    }
}
