<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\JobTraining;
use App\Models\Mentoring as ModelsMentoring;
use Livewire\Component;

class Mentoring extends Component
{
    public $mentorings, $time, $description;
    protected $listeners = ['acceptMentoring', 'declineMentoring'];

    public function confirmAcceptMentoring($studentID){
        $this->validate([
            'time' => 'required',
            'description' => 'required',
        ]);

        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Terima?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$studentID,
            'useMethod'=>'acceptMentoring',
        ]);
    }

    public function acceptMentoring($studentID){
        $lastSubmission = JobTraining::where(['user_id'=>$studentID])->latest()->first();

        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = ModelsMentoring::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'job_training_id'=>$lastSubmission->id,
            'mentoring_status_id' => 1,
        ])->first();

        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        ModelsMentoring::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'job_training_id'=>$lastSubmission->id,
            'mentoring_status_id' => 1,
        ])->update([
            'mentoring_status_id' => 3,
            'time' => $this->time,
            'description' => $this->description,
        ]);

        $this->time = '';
        $this->description = '';
        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menambahkan data',
            'text'=>'',
        ]);
    }

    public function confirmDeclineMentoring($studentID){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Tolak?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$studentID,
            'useMethod'=>'declineMentoring',
        ]);
    }

    public function declineMentoring($studentID){
        $lastSubmission = JobTraining::where(['user_id'=>$studentID])->latest()->first();

        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = ModelsMentoring::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'job_training_id'=>$lastSubmission->id,
            'academic_year_id' =>$lastSubmission->academic_year_id,
            'mentoring_status_id' => 1,
        ])->first();

        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        ModelsMentoring::where([
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'job_training_id'=>$lastSubmission->id,
            'mentoring_status_id' => 1,
        ])->update([
            'mentoring_status_id' => 2,
        ]);

        $this->mount();

        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menolak data',
            'text'=>'',
        ]);
    }

    public function mount(){
        $this->mentorings = ModelsMentoring::where([
            'lecturer_id' => auth()->user()->id,
            'mentoring_status_id' => 1,
        ])->with(['student'])->get();
    }
    
    public function render()
    {
        return view('livewire.lecturer.mentoring');
    }
}
