<?php

namespace App\Livewire\WeeklyReview;

use App\Services\WeeklyReviewService;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public string $week;

    public function mount(): void
    {
        $this->week = now()->toDateString();
    }

    public function render(WeeklyReviewService $service)
    {
        return view('livewire.weekly-review.index', [
            'review' => $service->review($this->week),
        ]);
    }

    public function previousWeek(): void
    {
        $this->week = Carbon::parse($this->week)
            ->subWeek()
            ->toDateString();
    }

    public function nextWeek(): void
    {
        $this->week = Carbon::parse($this->week)
            ->addWeek()
            ->toDateString();
    }

    public function currentWeek(): void
    {
        $this->week = now()->toDateString();
    }
}
