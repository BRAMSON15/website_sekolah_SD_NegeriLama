<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class TeacherPerformance extends Model
{
    protected $table = 'teacher_performances';
    
    protected $fillable = [
        'user_id',
        'materials_count',
        'videos_count',
        'assignments_count',
        'last_activity_at',
        'activity_score',
        'status', // 'active', 'inactive', 'pending'
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User (Guru)
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope: Guru aktif dalam 24 jam terakhir
     */
    public function scopeRecentlyActive($query)
    {
        return $query->where('last_activity_at', '>=', now()->subHours(24));
    }

    /**
     * Scope: Guru dengan status tertentu
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Update atau buat performance record
     */
    public static function updateOrCreateForTeacher($userId)
    {
        $teacher = User::with(['materials', 'videos', 'assignments'])->find($userId);
        
        if (!$teacher) {
            return null;
        }

        $lastActivity = TeacherActivity::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        $materialsCount = $teacher->materials_count ?? 0;
        $videosCount = $teacher->videos_count ?? 0;
        $assignmentsCount = $teacher->assignments_count ?? 0;

        // Hitung activity score (0-100)
        $activityScore = min(
            100,
            ($materialsCount * 10) + ($videosCount * 15) + ($assignmentsCount * 5)
        );

        // Tentukan status berdasarkan aktivitas terbaru
        $status = 'inactive';
        if ($lastActivity && $lastActivity->created_at->isAfter(now()->subHours(24))) {
            $status = 'active';
        } elseif ($lastActivity && $lastActivity->created_at->isAfter(now()->subDays(7))) {
            $status = 'pending';
        }

        return self::updateOrCreate(
            ['user_id' => $userId],
            [
                'materials_count' => $materialsCount,
                'videos_count' => $videosCount,
                'assignments_count' => $assignmentsCount,
                'last_activity_at' => $lastActivity?->created_at,
                'activity_score' => $activityScore,
                'status' => $status,
            ]
        );
    }

    /**
     * Hitung skor kesehatan guru (0-100)
     */
    public function getHealthScoreAttribute(): int
    {
        $baseScore = $this->activity_score ?? 0;
        
        // Bonus untuk aktivitas baru-baru ini
        if ($this->last_activity_at && $this->last_activity_at->isAfter(now()->subHours(1))) {
            $baseScore = min(100, $baseScore + 10);
        }

        return $baseScore;
    }

    /**
     * Tentukan badge status
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'active' => 'success',
            'pending' => 'warning',
            'inactive' => 'danger',
            default => 'secondary',
        };
    }
}
