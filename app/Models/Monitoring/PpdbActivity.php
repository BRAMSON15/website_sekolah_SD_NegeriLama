<?php

namespace App\Models\Monitoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbActivity extends Model
{
    use HasFactory;

    protected $table = 'ppdb_activities';

    protected $fillable = [
        'registration_id',
        'user_id',
        'activity_type',
        'description',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // Relationships
    public function registration()
    {
        return $this->belongsTo(\App\Models\PpdbRegistration::class, 'registration_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // Activity type constants
    const TYPE_CREATED = 'registration_created';
    const TYPE_STATUS_CHANGED = 'status_changed';
    const TYPE_FILE_UPLOADED = 'file_uploaded';
    const TYPE_NOTES_ADDED = 'notes_added';
    const TYPE_VERIFIED = 'registration_verified';
    const TYPE_REVIEWED = 'registration_reviewed';

    // Get activity type display name
    public function getActivityTypeLabel()
    {
        $labels = [
            self::TYPE_CREATED => 'Registrasi Baru',
            self::TYPE_STATUS_CHANGED => 'Status Berubah',
            self::TYPE_FILE_UPLOADED => 'File Diunggah',
            self::TYPE_NOTES_ADDED => 'Catatan Ditambah',
            self::TYPE_VERIFIED => 'Terverifikasi',
            self::TYPE_REVIEWED => 'Direview',
        ];
        return $labels[$this->activity_type] ?? $this->activity_type;
    }

    // Get activity icon
    public function getActivityIcon()
    {
        $icons = [
            self::TYPE_CREATED => 'fa-plus-circle',
            self::TYPE_STATUS_CHANGED => 'fa-exchange-alt',
            self::TYPE_FILE_UPLOADED => 'fa-file-upload',
            self::TYPE_NOTES_ADDED => 'fa-sticky-note',
            self::TYPE_VERIFIED => 'fa-check-circle',
            self::TYPE_REVIEWED => 'fa-eye',
        ];
        return $icons[$this->activity_type] ?? 'fa-circle';
    }
}
