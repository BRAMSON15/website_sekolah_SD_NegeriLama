<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'subject',
        'class_level',
        'description',
        'file_path',
        'file_type',
        'file_size',
        'downloads',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIconAttribute(): string
    {
        $type = strtolower($this->file_type . ' ' . $this->file_path);
        if (str_contains($type, 'pdf')) return 'fa-solid fa-file-pdf';
        if (str_contains($type, 'ppt')) return 'fa-solid fa-file-powerpoint';
        if (str_contains($type, 'doc') || str_contains($type, 'word')) return 'fa-solid fa-file-word';
        if (str_contains($type, 'xls') || str_contains($type, 'excel')) return 'fa-solid fa-file-excel';
        if (str_contains($type, 'zip') || str_contains($type, 'rar')) return 'fa-solid fa-file-zipper';
        return 'fa-solid fa-file-lines';
    }

    public function getIconColorAttribute(): string
    {
        $type = strtolower($this->file_type . ' ' . $this->file_path);
        if (str_contains($type, 'pdf')) return '#ef4444';
        if (str_contains($type, 'ppt')) return '#ea580c';
        if (str_contains($type, 'doc') || str_contains($type, 'word')) return '#2563eb';
        if (str_contains($type, 'xls') || str_contains($type, 'excel')) return '#16a34a';
        if (str_contains($type, 'zip') || str_contains($type, 'rar')) return '#7c3aed';
        return '#64748b';
    }
}
