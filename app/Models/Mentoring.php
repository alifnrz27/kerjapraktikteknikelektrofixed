<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentoring extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'lecturer_id',
        'job_training_id',
        'time',
        'description',
        'academic_year_id',
        'mentoring_status_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
