<?php

use App\Livewire\Availability\Index as AvailabilityIndex;
use App\Livewire\Dashboard;
use App\Livewire\Events\Index as EventsIndex;
use App\Livewire\Focus\Timer;
use App\Livewire\History\Index as HistoryIndex;
use App\Livewire\Progress\Index as ProgressIndex;
use App\Livewire\Routines\Index;
use App\Livewire\Routines\Tasks;
use App\Livewire\Settings\Index as SettingsIndex;
use App\Livewire\WeeklyReview\Index as WeeklyReviewIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/routines', Index::class)
    ->name('routines');

Route::get('/routines/{routine}/tasks', Tasks::class)
    ->name('routines.tasks');

Route::get('/dashboard', Dashboard::class)
    ->name('dashboard');

Route::get('/calendar', EventsIndex::class)
    ->name('calendar');

Route::get('/availability', AvailabilityIndex::class)
    ->name('availability');

Route::get('/focus', Timer::class)
    ->name('focus');

Route::get('/history', HistoryIndex::class)
    ->name('history');

Route::get('/progress', ProgressIndex::class)
    ->name('progress');

Route::get('/weekly-review', WeeklyReviewIndex::class)
    ->name('weekly-review');

Route::get('/settings', SettingsIndex::class)
    ->name('settings');
