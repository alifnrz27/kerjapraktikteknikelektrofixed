<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use App\Models\Mentoring as ModelsMentoring;
use App\Models\MentoringStatus;
use Livewire\Component;

class Mentoring extends Component
{
    public $submissionStatus, $mentoring, $mentoringStatus;
    protected $listeners = ['addMentoringStudent'];
    // protected $listeners = ['addMentoringStudent'];

    public function confirmAddMentoring(){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Ajukan bimbingan?",
            'text' => '',
            'confirmButtonText' => 'Ajukan',
            'key' =>'',
            'useMethod'=>'addMentoringStudent',
        ]);
    }

    public function addMentoringStudent()
    {
        $lastSubmission = JobTraining::where(['user_id'=>auth()->user()->id])->latest()->first();

        // cek apakah pengajuan sebelumnya belum selesai
        $addMentorings = ModelsMentoring::where([
            'student_id'=>auth()->user()->id,
        ])->get();

        $statusMentoring = true; // true berarti bisa mengajukan
        foreach($addMentorings as $mentoring){
            // kalo ada yg belum selesai, maka gaboleh ajuin
            if($mentoring->mentoring_status_id != 4 && $mentoring->mentoring_status_id != 2){ 
                $statusMentoring = false;
            }
        }

        if($statusMentoring == false){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Belum boleh mengajukan lagi, selesaikan dulu yang sebelumnya',
                'text'=>'',
            ]);
            return;
        }

        ModelsMentoring::create([
            'student_id'=>auth()->user()->id,
            'academic_year_id' => $lastSubmission->academic_year_id,
            'job_training_id'=>$lastSubmission->id,
            'mentoring_status_id' => 1,
            'lecturer_id' => $lastSubmission->lecturer_id,
            'time' => '-',
            'description'=> '-',
        ]);
        $this->mount($this->submissionStatus);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil mengajukan bimbingan',
            'text'=>'',
        ]);
    }

    public function mount($submissionStatus){
        $this->submissionStatus = $submissionStatus;
        $this->mentoring = ModelsMentoring::where(['student_id' => auth()->user()->id])->latest()->get();
        $this->mentoringStatus = MentoringStatus::get();
    }
    public function render()
    {
        return view('livewire.student.mentoring');
    }
}
