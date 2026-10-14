?php

namespace App\Services;

use App\Models\Monitoring\PpdbActivity;
use App\Models\PpdbRegistration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PpdbMonitoringService
{
    private const STATS_CACHE_TIME = 180; // 3 minutes
    private const ACTIVITIES_CACHE_TIME = 120; // 2 minutes

    /**
     * Get real-time monitoring statistics
     */
    public function getMonitoringStats(): array
    {
        return Cache::remember('ppdb.monitoring.stats', self::STATS_CACHE_TIME, function () {
            $total = PpdbRegistration::count();
            $pending = PpdbRegistration::where('status', 'pending')->count();
            $accepted = PpdbRegistration::whereIn('status', ['accepted', 'diterima'])->count();
            $rejected = PpdbRegistration::whereIn('status', ['rejected', 'ditolak'])->count();

            return [
                'total' => $total,
                'pending' => $pending,
                'accepted' => $accepted,
                'rejected' => $rejected,
                'pending_percent' => $total > 0 ? round(($pending / $total) * 100) : 0,
                'accepted_percent' => $total > 0 ? round(($accepted / $total) * 100) : 0,
                'rejected_percent' => $total > 0 ? round(($rejected / $total) * 100) : 0,
            ];
        });
    }

    /**
     * Get recent activities for activity feed
     */
    public function getRecentActivities(int $limit = 10): Collection
    {
        return PpdbActivity::with(['registration', 'user'])
            ->latest('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all activities with pagination for admin view
     */
    public function getAllActivities(int $perPage = 20)
    {
        return PpdbActivity::with(['registration', 'user'])
            ->latest('created_at')
            ->paginate($perPage);
    }

    /**
     * Record a new activity
     */
    public function recordActivity(
        int $registrationId,
        string $type,
        string $description,
        array $metadata = []
    ): PpdbActivity {
        $activity = PpdbActivity::create([
            'registration_id' => $registrationId,
            'user_id' => auth()->id(),
            'activity_type' => $type,
            'description' => $description,
            'metadata' => $metadata,
        ]);

        // Flush cache after recording activity
        Cache::forget('ppdb.monitoring.stats');

        return $activity;
    }

    /**
     * Search registrations with filters
     */
    public function searchRegistrations(
        ?string $search = null,
        ?string $status = null,
        ?array $dateRange = null
    ): Collection {
        $query = PpdbRegistration::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('parent_name', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($dateRange && count($dateRange) === 2) {
            $query->whereBetween('created_at', [
                $dateRange[0],
                $dateRange[1],
            ]);
        }

        return $query->latest('created_at')->get();
    }

    /**
     * Get registrations by status for dashboard summary
     */
    public function getRegistrationsByStatus(string $status): Collection
    {
        return PpdbRegistration::where('status', $status)
            ->with('activities')
            ->latest('created_at')
            ->limit(5)
            ->get();
    }

    /**
     * Get activity statistics (count by type)
     */
    public function getActivityStats(): array
    {
        $stats = [];
        $types = [
            PpdbActivity::TYPE_CREATED,
            PpdbActivity::TYPE_STATUS_CHANGED,
            PpdbActivity::TYPE_FILE_UPLOADED,
            PpdbActivity::TYPE_NOTES_ADDED,
        ];

        foreach ($types as $type) {
            $stats[$type] = PpdbActivity::where('activity_type', $type)->count();
        }

        return $stats;
    }

    /**
     * Get registrations updated in last N minutes (for real-time detection)
     */
    public function getRecentUpdates(int $minutes = 5): Collection
    {
        return PpdbRegistration::with('activities')
            ->where('updated_at', '>=', now()->subMinutes($minutes))
            ->latest('updated_at')
            ->get();
    }

    /**
     * Export registrations data to CSV
     */
    public function exportToCSV(?string $status = null)
    {
        $query = PpdbRegistration::query();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $registrations = $query->latest('created_at')->get();

        $csvData = "No.,Nomor Pendaftaran,Nama Calon,Tempat Lahir,Tanggal Lahir,Jenis Kelamin,Nama Orang Tua,No. HP,Email,Alamat,Status,Tgl Pendaftaran\n";

        foreach ($registrations as $index => $reg) {
            $csvData .= sprintf(
                "%d,\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                $index + 1,
                $reg->registration_number,
                $reg->student_name,
                $reg->birth_place,
                $reg->birth_date?->format('Y-m-d'),
                $reg->gender,
                $reg->parent_name,
                $reg->phone,
                $reg->email,
                str_replace('"', '""', $reg->address),
                $reg->status,
                $reg->created_at->format('Y-m-d H:i')
            );
        }

        return $csvData;
    }
}
