<?php

namespace App\Traits;

use App\Models\Monitoring\TeacherActivity;
use App\Models\Monitoring\TeacherPerformance;
use Illuminate\Support\Facades\Auth;

trait RecordsTeacherActivity
{
    /**
     * Record aktivitas guru
     * 
     * @param string $activityType
     * @param string $description
     * @param string|null $relatedModel
     * @param int|null $relatedModelId
     * @param array $metadata
     * @return TeacherActivity
     */
    public function recordActivity(
        string $activityType,
        string $description,
        ?string $relatedModel = null,
        ?int $relatedModelId = null,
        array $metadata = []
    ): TeacherActivity {
        $userId = Auth::id();

        $activity = TeacherActivity::recordActivity(
            $userId,
            $activityType,
            $description,
            $relatedModel,
            $relatedModelId,
            $metadata
        );

        // Update performa guru
        TeacherPerformance::updateOrCreateForTeacher($userId);

        // Trigger broadcast event jika diperlukan
        try {
            broadcast(new \App\Events\TeacherActivityCreated(
                $userId,
                $activityType,
                $description
            ))->toOthers();
        } catch (\Exception $e) {
            \Log::warning('Failed to broadcast teacher activity: ' . $e->getMessage());
        }

        return $activity;
    }

    /**
     * Record material upload activity
     */
    public function recordMaterialUpload($materialId, $title)
    {
        return $this->recordActivity(
            'material_upload',
            "Guru mengunggah materi: {$title}",
            'LearningMaterial',
            $materialId,
            [
                'material_title' => $title,
            ]
        );
    }

    /**
     * Record video upload activity
     */
    public function recordVideoUpload($videoId, $title)
    {
        return $this->recordActivity(
            'video_upload',
            "Guru mengunggah video: {$title}",
            'EducationalVideo',
            $videoId,
            [
                'video_title' => $title,
            ]
        );
    }

    /**
     * Record assignment creation activity
     */
    public function recordAssignmentCreate($assignmentId, $title)
    {
        return $this->recordActivity(
            'assignment_create',
            "Guru membuat tugas: {$title}",
            'Assignment',
            $assignmentId,
            [
                'assignment_title' => $title,
            ]
        );
    }
}
