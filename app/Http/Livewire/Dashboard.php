<?php

namespace App\Http\Livewire;

use App\Models\AcademicYear;
use App\Models\JobTraining;
use Livewire\Component;

class Dashboard extends Component
{

    public $academicYear, $submission, $submissionStatus;
    public function mount(){
        $this->academicYear = AcademicYear::where(['is_active' => 1])->first();
        $this->submission = JobTraining::where(['user_id' => auth()->user()->id])->with(['lecturer'])->latest()->first();
            
            if($this->submission){
                $this->submissionStatus = $this->submission->submission_status_id;
            }
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}
