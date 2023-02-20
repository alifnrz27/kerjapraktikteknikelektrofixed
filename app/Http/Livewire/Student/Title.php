<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use App\Models\Title as ModelsTitle;
use App\Models\TitleStatus;
use Livewire\Component;

class Title extends Component
{
    public $submissionStatus, $titles, $titleStatus, $title;
    protected $listeners = ['addTitle'];

    public function confirmAddTitle(){
        $this->validate([
            'title' => 'required',
        ]);

        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Ajukan judul?",
            'text' => '',
            'confirmButtonText' => 'Ajukan',
            'key' =>'',
            'useMethod'=>'addTitle',
        ]);
    }

    public function addTitle(){
        // cek apakah judul sudah diterima
        $check = ModelsTitle::where([
            'student_id' => auth()->user()->id,
            'title_status_id' => 3,
        ])->first();

        if($check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Judul sudah ada yang diterima',
                'text'=>'',
            ]);
            return;
        }

        // ambil data KP
        $lastSubmission = JobTraining::where([
            'user_id'=>auth()->user()->id,
        ])->latest()->first();

        // Masukkan judul baru
        ModelsTitle::create([
            'student_id' => auth()->user()->id,
            'lecturer_id' =>$lastSubmission->lecturer_id,
            'job_training_id' => $lastSubmission->id,
            'academic_year_id' => $lastSubmission->academic_year_id,
            'title_status_id' => 1,
            'title' => $this->title,
        ]);

        $this->title='';
        $this->mount($this->submissionStatus);
        JobTraining::where([
            'id' => $lastSubmission->id
        ])->update(['submission_status_id' => 16]);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil mengajukan judul',
            'text'=>'',
        ]);
    }

    public function mount($submissionStatus){
        $this->submissionStatus = $submissionStatus;
        $this->titles = ModelsTitle::where(['student_id' => auth()->user()->id])->latest()->get();
            $this->titleStatus = TitleStatus::get();
    }
    public function render()
    {
        return view('livewire.student.title');
    }
}
