<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_default_settings(): void
    {
        $settings = app(SettingsService::class)->all();

        $this->assertSame('08:00', $settings['day_start']);
        $this->assertSame('22:00', $settings['day_end']);
        $this->assertSame(15, $settings['minimum_block_minutes']);
        $this->assertTrue($settings['auto_schedule']);
    }

    public function test_it_can_save_a_setting(): void
    {
        $service = app(SettingsService::class);

        $service->set('day_start', '07:00');

        $this->assertSame(
            '07:00',
            $service->get('day_start')
        );
    }

    public function test_it_updates_an_existing_setting(): void
    {
        $service = app(SettingsService::class);

        $service->set('day_start', '07:00');
        $service->set('day_start', '09:00');

        $this->assertSame(
            1,
            Setting::where('key', 'day_start')->count()
        );

        $this->assertSame(
            '09:00',
            $service->get('day_start')
        );
    }

    public function test_it_returns_all_saved_settings(): void
    {
        $service = app(SettingsService::class);

        $service->set('day_start', '07:00');
        $service->set('day_end', '23:00');
        $service->set('minimum_block_minutes', 30);
        $service->set('auto_schedule', '0');

        $settings = $service->all();

        $this->assertSame('07:00', $settings['day_start']);
        $this->assertSame('23:00', $settings['day_end']);
        $this->assertSame(30, $settings['minimum_block_minutes']);
        $this->assertFalse($settings['auto_schedule']);
    }
}
