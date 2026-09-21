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
        'youtube_url',
        'duration',
        'views_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Parse and return YouTube embed URL
     */
    public function getEmbedUrlAttribute(): string
    {
        $url = $this->youtube_url;
        $id = '';

        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match)) {
            $id = $match[1];
        }

        if ($id) {
            return 'https://www.youtube.com/embed/' . $id;
        }

        return $url;
    }

    /**
     * Get YouTube thumbnail URL
     */
    public function getThumbnailUrlAttribute(): string
    {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $this->youtube_url, $match)) {
            return 'https://img.youtube.com/vi/' . $match[1] . '/hqdefault.jpg';
        }

        return '';
    }
}
