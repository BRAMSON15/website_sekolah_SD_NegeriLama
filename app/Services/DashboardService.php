<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\Feature;
use App\Models\PpdbRegistration;
use App\Models\SchoolSetting;
use App\Models\Student;
use App\Models\User;

class DashboardService
{
    /**
     * Get aggregated metrics and recent data for the Admin Dashboard.
     */
    public function getAdminDashboardData(): array
    {
        $stats = [
            'announcements'       => Announcement::count(),
            'activeAnnouncements' => Announcement::active()->count(),
            'features'            => Feature::count(),
            'settings'            => SchoolSetting::count(),
            'teachers'            => User::where('role', 'guru')->count(),
            'students'            => Student::count(),
            'ppdbTotal'           => PpdbRegistration::count(),
            'ppdbPending'         => PpdbRegistration::whereIn('status', ['pending', 'menunggu'])->count(),
            'ppdbAccepted'        => PpdbRegistration::whereIn('status', ['accepted', 'diterima'])->count(),
        ];

        $recentAnnouncements = Announcement::latest('published_at')
            ->take(5)
            ->get();

        return [
            'stats'               => $stats,
            'recentAnnouncements' => $recentAnnouncements,
        ];
    }

    /**
     * Get aggregated data for the Information Management Hub.
     */
    public function getInformationHubData(): array
    {
        return [
            'announcements'     => Announcement::latest('published_at')->take(5)->get(),
            'features'          => Feature::orderBy('order')->take(6)->get(),
            'announcementCount' => Announcement::count(),
            'featureCount'      => Feature::count(),
        ];
    }
}
