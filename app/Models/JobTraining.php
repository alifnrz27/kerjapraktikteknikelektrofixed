<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTraining extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'lecturer_id',
        'team_id',
        'academic_year_id',
        'submission_status_id',
        'place',
        'name_leader',
        'address',
        'number',
        'start',
        'end',
        'form',
        'transcript',
        'vaccine',
        'from_major',
        'from_company',
        'form_presentation',
        'result_company',
        'log_activity',
        'form_mentoring',
        'report',
        'screenshot_before_presentation',
        'statement_letter',
        'evaluated_id',
        'date_presentation',
        'report_of_presentation',
        'notes',
        'report_revision',
        'screenshot_after_presentation',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function submissionStatus()
    {
        return $this->belongsTo(SubmissionStatus::class, 'submission_status_id');
    }
}
