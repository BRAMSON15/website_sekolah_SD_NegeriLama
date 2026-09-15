<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'student_name',
        'birth_place',
        'birth_date',
        'gender',
        'nik',
        'kk_number',
        'parent_name',
        'phone',
        'email',
        'address',
        'previous_school',
        'status',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
}
