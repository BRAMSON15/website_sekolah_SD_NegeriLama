<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\User;
use App\Models\Monitoring\TeacherActivity;
use App\Models\Monitoring\TeacherPerformance;
use Illuminate\Support\Collection;

class TeacherActivityMonitor extends Component
{
    use WithPagination;

    /**
     * Filter & Search
     */
    public string $search = '';
    public string $filterStatus = 'all'; // all, active, pending, inactive
    public string $filterActivityType = 'all'; // all, material_upload, video_upload, assignment_create
    
    /**
     * Polling interval dalam milidetik
     */
    public int $pollingInterval = 3000; // 3 detik
    
    /**
     * Pagination
     */
    public int $perPage = 10;

    /**
     * Mount component
     */
    public function mount(?int $pollingInterval = null)
    {
        if ($pollingInterval) {
            $this->pollingInterval = $pollingInterval;
        }

        // Set initial filter dari query string jika ada
        $this->filterStatus = request('status', 'all');
        $this->filterActivityType = request('activity_type', 'all');
    }

    /**
     * Query aktivitas yang sudah difilter, sebelum dipaginasi.
     */
    protected function filteredActivitiesQuery()
    {
        $query = TeacherActivity::with('teacher')
            ->latest('created_at');

        // Filter berdasarkan search
        if ($this->search) {
            $query->whereHas('teacher', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('nip', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        // Filter berdasarkan activity type
        if ($this->filterActivityType !== 'all') {
            $query->where('activity_type', $this->filterActivityType);
        }

        // Filter berdasarkan status guru
        if ($this->filterStatus !== 'all') {
            $query->whereHas('teacher.performance', function ($q) {
                $q->where('status', $this->filterStatus);
            });
        }

        return $query;
    }

    /**
     * Computed: Dapatkan data guru yang sedang aktif dengan polling
     */
    #[Computed]
    public function teacherActivities()
    {
        return $this->filteredActivitiesQuery()->paginate($this->perPage);
    }

    /**
     * Computed: Jumlah aktivitas per tipe dari seluruh hasil filter
     */
    #[Computed]
    public function activityTypeCounts()
    {
        return $this->filteredActivitiesQuery()
            ->reorder()
            ->selectRaw('activity_type, COUNT(*) as aggregate')
            ->groupBy('activity_type')
            ->pluck('aggregate', 'activity_type');
    }

    /**
     * Computed: Statistik guru aktif
     */
    #[Computed]
    public function teacherStats()
    {
        return [
            'total_active' => User::where('role', 'guru')
                ->whereHas('performance', function ($q) {
                    $q->where('status', 'active');
                })
                ->count(),
            'total_pending' => User::where('role', 'guru')
                ->whereHas('performance', function ($q) {
                    $q->where('status', 'pending');
                })
                ->count(),
            'total_inactive' => User::where('role', 'guru')
                ->whereHas('performance', function ($q) {
                    $q->where('status', 'inactive');
                })
                ->count(),
            'total_all' => User::where('role', 'guru')->count(),
        ];
    }

    /**
     * Computed: Aktivitas dalam 24 jam terakhir
     */
    #[Computed]
    public function recentActivityCount()
    {
        return TeacherActivity::where('created_at', '>=', now()->subHours(24))->count();
    }

    /**
     * Computed: Top 5 guru paling aktif
     */
    #[Computed]
    public function topTeachers()
    {
        return TeacherPerformance::with('teacher')
            ->where('status', 'active')
            ->orderBy('activity_score', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Update search filter
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Update status filter
     */
    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    /**
     * Update activity type filter
     */
    public function updatedFilterActivityType()
    {
        $this->resetPage();
    }

    /**
     * Event listener: Activity baru ditambahkan
     */
    #[On('teacher-activity-created')]
    public function onActivityCreated($userId, $activityType, $description)
    {
        // Refresh computed properties
        $this->dispatch('activity-refreshed');
    }

    /**
     * Refresh data (dipanggil oleh polling)
     */
    public function refresh()
    {
        // Computed properties akan refresh otomatis
    }

    /**
     * Reset filters
     */
    public function resetFilters()
    {
        $this->search = '';
        $this->filterStatus = 'all';
        $this->filterActivityType = 'all';
        $this->resetPage();
    }

    /**
     * Render view
     */
    public function render()
    {
        return view('livewire.teacher-activity-monitor');
    }
}
