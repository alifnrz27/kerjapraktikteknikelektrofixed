<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\JobTraining;
use Livewire\Component;

class Student extends Component
{
    public $academicYear, $students;
    public function mount($academicYear){
        $this->academicYear =$academicYear;
        $this->students = JobTraining::where([
            'lecturer_id' => auth()->user()->id,
            'academic_year_id' => $this->academicYear->id
        ])->orderBy('submission_status_id', 'asc')->with(['user', 'submissionStatus'])->get();
    }
    public function render()
    {
        return view('livewire.lecturer.student');
    }
}
