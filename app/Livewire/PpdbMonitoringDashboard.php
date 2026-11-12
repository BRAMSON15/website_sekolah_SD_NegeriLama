<?php

namespace App\Livewire;

use App\Services\PpdbMonitoringService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PpdbMonitoringDashboard extends Component
{
    public string $search = '';
    public string $statusFilter = 'all';
    public ?string $dateFrom = null;
    public ?string $dateTo = null;

    private PpdbMonitoringService $monitoringService;

    public function boot(PpdbMonitoringService $service)
    {
        $this->monitoringService = $service;
    }

    #[Computed(cache: true)]
    public function stats()
    {
        return $this->monitoringService->getMonitoringStats();
    }

    #[Computed(cache: true)]
    public function recentActivities()
    {
        return $this->monitoringService->getRecentActivities(10);
    }

    #[Computed(cache: true)]
    public function searchResults()
    {
        if (!$this->search && $this->statusFilter === 'all' && !$this->dateFrom) {
            return collect();
        }

        $dateRange = null;
        if ($this->dateFrom && $this->dateTo) {
            $dateRange = [$this->dateFrom, $this->dateTo];
        }

        return $this->monitoringService->searchRegistrations(
            $this->search ?: null,
            $this->statusFilter !== 'all' ? $this->statusFilter : null,
            $dateRange
        );
    }

    public function exportCSV()
    {
        $csv = $this->monitoringService->exportToCSV(
            $this->statusFilter !== 'all' ? $this->statusFilter : null
        );

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="ppdb-registrations-'.now()->format('Y-m-d-Hi').'.csv"');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.ppdb-monitoring-dashboard');
    }
}
