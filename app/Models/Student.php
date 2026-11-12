<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
        'nisn',
        'name',
        'gender',
    ];

    public function grades()
    {
        return $this->hasMany(AssignmentGrade::class);
    }
}
