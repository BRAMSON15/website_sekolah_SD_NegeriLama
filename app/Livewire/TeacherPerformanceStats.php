<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\User;
use App\Models\Monitoring\TeacherPerformance;

class TeacherPerformanceStats extends Component
{
    /**
     * Polling interval dalam milidetik
     */
    public int $pollingInterval = 5000; // 5 detik
    
    /**
     * Sort option
     */
    public string $sortBy = 'activity_score'; // activity_score, last_activity_at, materials_count, videos_count
    public string $sortOrder = 'desc'; // asc, desc

    /**
     * Mount component
     */
    public function mount()
    {
        // Initialize jika perlu
    }

    /**
     * Computed: Semua guru dengan performa terbaru
     */
    #[Computed]
    public function teacherPerformances()
    {
        $query = TeacherPerformance::with('teacher');

        // Sort
        $sortColumn = match ($this->sortBy) {
            'last_activity_at' => 'last_activity_at',
            'materials_count' => 'materials_count',
            'videos_count' => 'videos_count',
            default => 'activity_score',
        };

        $query->orderBy($sortColumn, $this->sortOrder);

        return $query->get();
    }

    /**
     * Computed: Metrik keseluruhan
     */
    #[Computed]
    public function overallMetrics()
    {
        $performances = TeacherPerformance::all();

        return [
            'average_activity_score' => $performances->avg('activity_score') ?? 0,
            'total_materials' => $performances->sum('materials_count'),
            'total_videos' => $performances->sum('videos_count'),
            'total_assignments' => $performances->sum('assignments_count'),
            'active_teachers' => $performances->where('status', 'active')->count(),
            'pending_teachers' => $performances->where('status', 'pending')->count(),
            'inactive_teachers' => $performances->where('status', 'inactive')->count(),
        ];
    }

    /**
     * Computed: Status distribution
     */
    #[Computed]
    public function statusDistribution()
    {
        $performances = TeacherPerformance::all();

        return [
            'active' => [
                'count' => $performances->where('status', 'active')->count(),
                'percentage' => $performances->where('status', 'active')->count() / max($performances->count(), 1) * 100,
            ],
            'pending' => [
                'count' => $performances->where('status', 'pending')->count(),
                'percentage' => $performances->where('status', 'pending')->count() / max($performances->count(), 1) * 100,
            ],
            'inactive' => [
                'count' => $performances->where('status', 'inactive')->count(),
                'percentage' => $performances->where('status', 'inactive')->count() / max($performances->count(), 1) * 100,
            ],
        ];
    }

    /**
     * Computed: Top performers
     */
    #[Computed]
    public function topPerformers()
    {
        return TeacherPerformance::with('teacher')
            ->orderBy('activity_score', 'desc')
            ->take(3)
            ->get();
    }

    /**
     * Computed: Guru yang perlu perhatian (inactive > 7 hari)
     */
    #[Computed]
    public function needsAttention()
    {
        return TeacherPerformance::with('teacher')
            ->where('status', 'inactive')
            ->where(function ($q) {
                $q->whereNull('last_activity_at')
                  ->orWhere('last_activity_at', '<', now()->subDays(7));
            })
            ->take(5)
            ->get();
    }

    /**
     * Update sort
     */
    public function updateSort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortOrder = 'desc';
        }
    }

    /**
     * Event listener: Performance updated
     */
    #[On('teacher-performance-updated')]
    public function onPerformanceUpdated($userId)
    {
        // Force refresh computed properties
        $this->dispatch('performance-refreshed');
    }

    /**
     * Refresh data (dipanggil oleh polling)
     */
    public function refresh()
    {
        // Computed properties akan refresh otomatis
    }

    /**
     * Render view
     */
    public function render()
    {
        return view('livewire.teacher-performance-stats');
    }
}
