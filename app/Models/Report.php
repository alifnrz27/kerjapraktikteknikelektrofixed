<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'lecturer_id',
        'report',
        'description',
        'academic_year_id',
        'report_status_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
