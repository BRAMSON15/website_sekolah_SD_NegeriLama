<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class TeacherActivity extends Model
{
    protected $table = 'teacher_activities';
    
    protected $fillable = [
        'user_id',
        'activity_type', // 'material_upload', 'video_upload', 'assignment_create', 'attendance_input'
        'description',
        'related_model',
        'related_model_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
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
     * Scope: Aktivitas terbaru dari guru
     */
    public function scopeRecent($query, $minutes = 30)
    {
        return $query->where('created_at', '>=', now()->subMinutes($minutes));
    }

    /**
     * Scope: Aktivitas dari guru spesifik
     */
    public function scopeFromTeacher($query, $teacherId)
    {
        return $query->where('user_id', $teacherId);
    }

    /**
     * Scope: Filter berdasarkan tipe aktivitas
     */
    public function scopeByActivityType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Catat aktivitas guru
     */
    public static function recordActivity(
        $userId,
        $activityType,
        $description,
        $relatedModel = null,
        $relatedModelId = null,
        $metadata = []
    ) {
        return self::create([
            'user_id' => $userId,
            'activity_type' => $activityType,
            'description' => $description,
            'related_model' => $relatedModel,
            'related_model_id' => $relatedModelId,
            'metadata' => $metadata,
        ]);
    }
}
