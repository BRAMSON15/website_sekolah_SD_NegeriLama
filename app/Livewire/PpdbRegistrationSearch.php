?php

namespace App\Livewire;

use App\Services\PpdbMonitoringService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PpdbRegistrationSearch extends Component
{
    public string $search = '';
    public string $status = 'all';
    public ?string $dateFrom = null;
    public ?string $dateTo = null;

    private PpdbMonitoringService $monitoringService;

    public function boot(PpdbMonitoringService $service)
    {
        $this->monitoringService = $service;
    }

    #[Computed]
    public function results()
    {
        if (!$this->search && $this->status === 'all' && !$this->dateFrom) {
            return collect();
        }

        $dateRange = null;
        if ($this->dateFrom && $this->dateTo) {
            $dateRange = [$this->dateFrom.' 00:00:00', $this->dateTo.' 23:59:59'];
        }

        return $this->monitoringService->searchRegistrations(
            $this->search ?: null,
            $this->status !== 'all' ? $this->status : null,
            $dateRange
        );
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->status = 'all';
        $this->dateFrom = null;
        $this->dateTo = null;
    }

    public function render()
    {
        return view('livewire.ppdb-registration-search');
    }
}
