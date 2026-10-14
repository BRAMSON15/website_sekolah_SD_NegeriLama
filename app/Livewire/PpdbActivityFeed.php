?php

namespace App\Livewire;

use App\Services\PpdbMonitoringService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PpdbActivityFeed extends Component
{
    public int $limit = 10;

    private PpdbMonitoringService $monitoringService;

    public function boot(PpdbMonitoringService $service)
    {
        $this->monitoringService = $service;
    }

    #[Computed(cache: true)]
    public function activities()
    {
        return $this->monitoringService->getRecentActivities($this->limit);
    }

    public function loadMore()
    {
        $this->limit += 10;
    }

    public function render()
    {
        return view('livewire.ppdb-activity-feed');
    }
}
