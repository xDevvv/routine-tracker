<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    public function get(string $key, mixed $default = null): mixed
    {
        return Setting::query()
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value]
        );
    }

    public function all(): array
    {
        return [
            'day_start' => $this->get('day_start', '08:00'),
            'day_end' => $this->get('day_end', '22:00'),

            'minimum_block_minutes' => (int) $this->get(
                'minimum_block_minutes',
                15
            ),

            'auto_schedule' => $this->get(
                'auto_schedule',
                '1'
            ) === '1',
        ];
    }
}
