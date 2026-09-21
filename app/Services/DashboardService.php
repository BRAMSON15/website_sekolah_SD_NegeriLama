<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\Feature;
use App\Models\SchoolSetting;

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
