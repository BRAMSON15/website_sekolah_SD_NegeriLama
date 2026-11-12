<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'subject',
        'class_level',
        'description',
        'source_type', // 'youtube' or 'google_drive'
        'video_url',
        'youtube_url',
        'duration',
        'views_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the effective video URL (supporting both video_url and legacy youtube_url)
     */
    public function getEffectiveUrlAttribute(): string
    {
        return (string) ($this->video_url ?: $this->youtube_url ?: '');
    }

    /**
     * Determine or get the source type ('youtube' or 'google_drive')
     */
    public function getSourceTypeAttribute($value): string
    {
        if (!empty($value)) {
            return strtolower($value);
        }

        $url = $this->effective_url;
        if (str_contains($url, 'drive.google.com')) {
            return 'google_drive';
        }

        return 'youtube';
    }

    /**
     * Check if the video is from Google Drive
     */
    public function getIsDriveAttribute(): bool
    {
        return $this->source_type === 'google_drive';
    }

    /**
     * Check if the video is from YouTube
     */
    public function getIsYoutubeAttribute(): bool
    {
        return $this->source_type === 'youtube';
    }

    /**
     * Extract Google Drive File ID
     */
    public function getDriveIdAttribute(): ?string
    {
        $url = $this->effective_url;

        // Pattern 1: /file/d/{ID}
        if (preg_match('#/file/d/([a-zA-Z0-9_-]+)#i', $url, $matches)) {
            return $matches[1];
        }

        // Pattern 2: id={ID}
        if (preg_match('#[?&]id=([a-zA-Z0-9_-]+)#i', $url, $matches)) {
            return $matches[1];
        }

        // Pattern 3: /d/{ID}
        if (preg_match('#/d/([a-zA-Z0-9_-]+)#i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Extract YouTube Video ID
     */
    public function getYoutubeIdAttribute(): ?string
    {
        $url = $this->effective_url;

        // Standard, shorts, embed, or youtu.be
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?|shorts)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Parse and return responsive embed URL
     */
    public function getEmbedUrlAttribute(): string
    {
        if ($this->is_drive) {
            $driveId = $this->drive_id;
            if ($driveId) {
                return 'https://drive.google.com/file/d/' . $driveId . '/preview';
            }
        }

        // Default or YouTube
        $youtubeId = $this->youtube_id;
        if ($youtubeId) {
            return 'https://www.youtube.com/embed/' . $youtubeId;
        }

        return $this->effective_url;
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->is_drive) {
            $driveId = $this->drive_id;
            if ($driveId) {
                return 'https://drive.google.com/thumbnail?id=' . $driveId . '&sz=w800';
            }
            return '';
        }

        $youtubeId = $this->youtube_id;
        if ($youtubeId) {
            return 'https://img.youtube.com/vi/' . $youtubeId . '/hqdefault.jpg';
        }

        return '';
    }

    /**
     * Source display badge details
     */
    public function getSourceBadgeAttribute(): array
    {
        if ($this->is_drive) {
            return [
                'label'    => 'Google Drive',
                'icon'     => 'fa-brands fa-google-drive',
                'color'    => '#0284c7',
                'bg_color' => '#e0f2fe',
                'border'   => '#bae6fd',
            ];
        }

        return [
            'label'    => 'YouTube',
            'icon'     => 'fa-brands fa-youtube',
            'color'    => '#dc2626',
            'bg_color' => '#fee2e2',
            'border'   => '#fecaca',
        ];
    }
}
