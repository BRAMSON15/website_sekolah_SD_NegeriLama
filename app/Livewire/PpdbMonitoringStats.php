<?php

namespace App\Livewire;

use App\Services\PpdbMonitoringService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PpdbMonitoringStats extends Component
{
    private PpdbMonitoringService $monitoringService;
    private array $previousStats = [];

    public function boot(PpdbMonitoringService $service)
    {
        $this->monitoringService = $service;
        $this->previousStats = cache()->get('ppdb.monitoring.stats.previous', []);
    }

    #[Computed(cache: true, persist: true)]
    public function stats()
    {
        $stats = $this->monitoringService->getMonitoringStats();
        
        // Store current stats as previous for next poll
        cache()->put('ppdb.monitoring.stats.previous', $stats, now()->addMinutes(1));
        
        return $stats;
    }

    public function getDelta(string $key): string
    {
        $current = $this->stats[$key] ?? 0;
        $previous = $this->previousStats[$key] ?? 0;
        $delta = $current - $previous;

        if ($delta > 0) {
            return "+{$delta}";
        } elseif ($delta < 0) {
            return "{$delta}";
        }
        return "0";
    }

    public function render()
    {
        return view('livewire.ppdb-monitoring-stats');
    }
}
