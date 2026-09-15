<?php

namespace App\Livewire\Progress;

use App\Services\ProgressService;
use Livewire\Component;

class Index extends Component
{
    public function render(ProgressService $progressService)
    {
        return view('livewire.progress.index', [
            'today' => $progressService->getToday(),
            'week' => $progressService->getThisWeek(),
            'byRoutine' => $progressService->getByRoutine(),
            'plannedVsActual' => $progressService->getPlannedVsActual(),
        ]);
    }
}
