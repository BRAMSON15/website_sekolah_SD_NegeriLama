<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WebsiteContentService;
use App\Services\TeacherMonitoringService;

class TeacherMonitoringController extends Controller
{
    public function __construct(
        protected WebsiteContentService $websiteService,
        protected TeacherMonitoringService $monitoringService
    ) {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!in_array($user->role, ['kepala_sekolah', 'kepsek', 'admin'])) {
                abort(403, 'Unauthorized access to teacher monitoring');
            }
            return $next($request);
        });
    }

    /**
     * Halaman Dashboard Aktivitas Guru Real-time
     */
    public function activityDashboard()
    {
        $settings = $this->websiteService->getSettings();
        
        return view('kepsek.monitoring.activity', [
            'settings' => $settings,
            'pollingInterval' => 3000, // 3 detik
        ]);
    }

    /**
     * Halaman Dashboard Performa Guru Real-time
     */
    public function performanceDashboard()
    {
        $settings = $this->websiteService->getSettings();
        
        return view('kepsek.monitoring.performance', [
            'settings' => $settings,
            'pollingInterval' => 5000, // 5 detik
        ]);
    }

    /**
     * API: Dapatkan aktivitas guru real-time (untuk AJAX/Polling)
     */
    public function getActivitiesData(Request $request)
    {
        $activities = $this->monitoringService->getActivitiesData($request);

        return response()->json([
            'success' => true,
            'data' => $activities->items(),
            'pagination' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'total' => $activities->total(),
                'per_page' => $activities->perPage(),
            ],
        ]);
    }

    /**
     * API: Dapatkan statistik aktivitas guru
     */
    public function getActivitiesStats()
    {
        $result = $this->monitoringService->getActivitiesStats();

        return response()->json([
            'success' => true,
            'stats' => $result['stats'],
            'top_teachers' => $result['top_teachers'],
        ]);
    }

    /**
     * API: Dapatkan performa guru real-time
     */
    public function getPerformanceData(Request $request)
    {
        $performances = $this->monitoringService->getPerformanceData($request);

        return response()->json([
            'success' => true,
            'data' => $performances,
        ]);
    }

    /**
     * API: Dapatkan statistik performa guru keseluruhan
     */
    public function getPerformanceStats()
    {
        $result = $this->monitoringService->getPerformanceStats();

        return response()->json([
            'success' => true,
            'stats' => $result['stats'],
            'status_distribution' => $result['status_distribution'],
            'top_performers' => $result['top_performers'],
            'needs_attention' => $result['needs_attention'],
        ]);
    }

    /**
     * API: Record aktivitas guru (dipanggil saat guru melakukan aksi)
     */
    public function recordActivity(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity_type' => 'required|string|in:material_upload,video_upload,assignment_create,attendance_input',
            'description' => 'required|string',
            'related_model' => 'nullable|string',
            'related_model_id' => 'nullable|integer',
            'metadata' => 'nullable|array',
        ]);

        try {
            $activity = $this->monitoringService->recordActivity($validated);

            return response()->json([
                'success' => true,
                'message' => 'Activity recorded successfully',
                'activity' => $activity,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Update performa guru secara manual
     */
    public function updatePerformance($userId)
    {
        try {
            $performance = $this->monitoringService->updatePerformance($userId);

            return response()->json([
                'success' => true,
                'message' => 'Performance updated successfully',
                'performance' => $performance,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Export aktivitas guru ke CSV/Excel
     */
    public function exportActivities(Request $request)
    {
        $csv = $this->monitoringService->exportActivitiesAsCSV($request);

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="teacher_activities_' . now()->format('Y-m-d_His') . '.csv"');
    }
}
