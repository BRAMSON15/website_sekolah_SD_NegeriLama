<?php

namespace App\Services;

use App\Models\User;
use App\Models\Monitoring\TeacherActivity;
use App\Models\Monitoring\TeacherPerformance;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class TeacherMonitoringService
{
    /* -------------------------------------------------------
     * 1. ACTIVITY MONITORING DATA
     * ----------------------------------------------------- */

    /**
     * Dapatkan data aktivitas guru dengan filtering dan pagination
     * 
     * @param Request $request
     * @return Paginator
     */
    public function getActivitiesData(Request $request): Paginator
    {
        $query = TeacherActivity::with('teacher')->latest('created_at');

        // Filter search
        if ($request->has('search') && $request->search) {
            $search = trim($request->search);
            $query->whereHas('teacher', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter activity type
        if ($request->has('activity_type') && $request->activity_type !== 'all') {
            $query->where('activity_type', $request->activity_type);
        }

        // Filter status
        if ($request->has('status') && $request->status !== 'all') {
            $query->whereHas('teacher.performance', function ($q) {
                $q->where('status', $request->status);
            });
        }

        return $query->paginate($request->get('per_page', 10));
    }

    /**
     * Dapatkan statistik aktivitas guru
     * 
     * @return array
     */
    public function getActivitiesStats(): array
    {
        $totalActive = User::where('role', 'guru')
            ->whereHas('performance', function ($q) {
                $q->where('status', 'active');
            })->count();

        $totalPending = User::where('role', 'guru')
            ->whereHas('performance', function ($q) {
                $q->where('status', 'pending');
            })->count();

        $totalInactive = User::where('role', 'guru')
            ->whereHas('performance', function ($q) {
                $q->where('status', 'inactive');
            })->count();

        $recentActivityCount = TeacherActivity::where('created_at', '>=', now()->subHours(24))->count();

        $topTeachers = TeacherPerformance::with('teacher')
            ->where('status', 'active')
            ->orderBy('activity_score', 'desc')
            ->take(5)
            ->get();

        return [
            'stats' => [
                'total_active' => $totalActive,
                'total_pending' => $totalPending,
                'total_inactive' => $totalInactive,
                'total_all' => User::where('role', 'guru')->count(),
                'recent_activity_count' => $recentActivityCount,
            ],
            'top_teachers' => $topTeachers,
        ];
    }

    /* -------------------------------------------------------
     * 2. PERFORMANCE MONITORING DATA
     * ----------------------------------------------------- */

    /**
     * Dapatkan data performa guru dengan sorting
     * 
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPerformanceData(Request $request)
    {
        $sortBy = $request->get('sort_by', 'activity_score');
        $sortOrder = $request->get('sort_order', 'desc');

        $sortColumn = match ($sortBy) {
            'last_activity_at' => 'last_activity_at',
            'materials_count' => 'materials_count',
            'videos_count' => 'videos_count',
            default => 'activity_score',
        };

        return TeacherPerformance::with('teacher')
            ->orderBy($sortColumn, $sortOrder)
            ->get();
    }

    /**
     * Dapatkan statistik performa guru keseluruhan
     * 
     * @return array
     */
    public function getPerformanceStats(): array
    {
        $performances = TeacherPerformance::all();

        $stats = [
            'average_activity_score' => $performances->avg('activity_score') ?? 0,
            'total_materials' => $performances->sum('materials_count'),
            'total_videos' => $performances->sum('videos_count'),
            'total_assignments' => $performances->sum('assignments_count'),
            'active_teachers' => $performances->where('status', 'active')->count(),
            'pending_teachers' => $performances->where('status', 'pending')->count(),
            'inactive_teachers' => $performances->where('status', 'inactive')->count(),
        ];

        $statusDistribution = $this->calculateStatusDistribution($performances);
        $topPerformers = $this->getTopPerformers(3);
        $needsAttention = $this->getNeedsAttention(5);

        return [
            'stats' => $stats,
            'status_distribution' => $statusDistribution,
            'top_performers' => $topPerformers,
            'needs_attention' => $needsAttention,
        ];
    }

    /* -------------------------------------------------------
     * 3. ACTIVITY RECORDING & MANAGEMENT
     * ----------------------------------------------------- */

    /**
     * Record aktivitas guru baru
     * 
     * @param array $data
     * @return TeacherActivity
     * @throws \Exception
     */
    public function recordActivity(array $data): TeacherActivity
    {
        try {
            $activity = TeacherActivity::recordActivity(
                $data['user_id'],
                $data['activity_type'],
                $data['description'],
                $data['related_model'] ?? null,
                $data['related_model_id'] ?? null,
                $data['metadata'] ?? []
            );

            // Update performance record
            TeacherPerformance::updateOrCreateForTeacher($data['user_id']);

            // Broadcast event untuk polling real-time
            broadcast(new \App\Events\TeacherActivityCreated(
                $data['user_id'],
                $data['activity_type'],
                $data['description']
            ))->toOthers();

            return $activity;
        } catch (\Exception $e) {
            throw new \Exception('Failed to record activity: ' . $e->getMessage());
        }
    }

    /**
     * Update performa guru secara manual
     * 
     * @param int $userId
     * @return TeacherPerformance
     * @throws \Exception
     */
    public function updatePerformance(int $userId): TeacherPerformance
    {
        try {
            return TeacherPerformance::updateOrCreateForTeacher($userId);
        } catch (\Exception $e) {
            throw new \Exception('Failed to update performance: ' . $e->getMessage());
        }
    }

    /* -------------------------------------------------------
     * 4. DATA EXPORT
     * ----------------------------------------------------- */

    /**
     * Export aktivitas guru ke format CSV
     * 
     * @param Request $request
     * @return string
     */
    public function exportActivitiesAsCSV(Request $request): string
    {
        $activities = $this->filterActivitiesForExport($request);

        $csv = "Nama Guru,NIP,Tipe Aktivitas,Deskripsi,Waktu\n";
        foreach ($activities as $activity) {
            $csv .= "{$activity->teacher->name},{$activity->teacher->nip},{$activity->activity_type},\"{$activity->description}\",{$activity->created_at->format('Y-m-d H:i:s')}\n";
        }

        return $csv;
    }

    /* -------------------------------------------------------
     * 5. HELPER METHODS (PRIVATE)
     * ----------------------------------------------------- */

    /**
     * Filter aktivitas untuk export
     * 
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function filterActivitiesForExport(Request $request)
    {
        $query = TeacherActivity::with('teacher')->latest('created_at');

        if ($request->has('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return $query->get();
    }

    /**
     * Hitung distribusi status guru
     * 
     * @param \Illuminate\Support\Collection $performances
     * @return array
     */
    private function calculateStatusDistribution($performances): array
    {
        $totalCount = max($performances->count(), 1);

        return [
            'active' => [
                'count' => $performances->where('status', 'active')->count(),
                'percentage' => ($performances->where('status', 'active')->count() / $totalCount) * 100,
            ],
            'pending' => [
                'count' => $performances->where('status', 'pending')->count(),
                'percentage' => ($performances->where('status', 'pending')->count() / $totalCount) * 100,
            ],
            'inactive' => [
                'count' => $performances->where('status', 'inactive')->count(),
                'percentage' => ($performances->where('status', 'inactive')->count() / $totalCount) * 100,
            ],
        ];
    }

    /**
     * Dapatkan top performers
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getTopPerformers(int $limit = 3)
    {
        return TeacherPerformance::with('teacher')
            ->orderBy('activity_score', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Dapatkan guru yang perlu perhatian (inactive > 7 hari)
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getNeedsAttention(int $limit = 5)
    {
        return TeacherPerformance::with('teacher')
            ->where('status', 'inactive')
            ->where(function ($q) {
                $q->whereNull('last_activity_at')
                  ->orWhere('last_activity_at', '<', now()->subDays(7));
            })
            ->take($limit)
            ->get();
    }
}
