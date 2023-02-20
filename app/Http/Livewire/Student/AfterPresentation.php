<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use Livewire\Component;

class AfterPresentation extends Component
{
    public $report_of_presentation, $notes, $report_revision, $screenshot_after_presentation;
    protected $listeners = ['addAfterPresentation'];
    public function confirmAddAfterPresentation(){
        $this->validate([
            'report_of_presentation'=>'required',
            'notes'=>'required',
            'report_revision'=>'required',
            'screenshot_after_presentation'=>'required',
        ]);
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Kirim?",
            'text' => '',
            'confirmButtonText' => 'Kirim',
            'key' =>'',
            'useMethod'=>'addAfterPresentation',
        ]);
    }

    public function addAfterPresentation(){
        $this->validate([
            'report_of_presentation'=>'required',
            'notes'=>'required',
            'report_revision'=>'required',
            'screenshot_after_presentation'=>'required',
        ]);

        $lastSubmission = JobTraining::where(['user_id' => auth()->user()->id])->latest()->first();
        if($lastSubmission->submission_status_id == 26){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Menunggu pengajuan sebelumnya',
                'text'=>'',
            ]);
            return;
        }

        if($lastSubmission->submission_status_id == 24){
            JobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' => $lastSubmission->academic_year_id,
                'submission_status_id' => 24,
            ])->update([
                'report_of_presentation'=>$this->report_of_presentation,
                'notes'=>$this->notes,
                'report_revision'=>$this->report_revision,
                'screenshot_after_presentation'=>$this->screenshot_after_presentation,
                'submission_status_id' => 26,
            ]);
        }
        elseif($lastSubmission->submission_status_id == 25){
            JobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' => $lastSubmission->academic_year_id,
                'submission_status_id' => 25,
            ])->update([
                'report_of_presentation'=>$this->report_of_presentation,
                'notes'=>$this->notes,
                'report_revision'=>$this->report_revision,
                'screenshot_after_presentation'=>$this->screenshot_after_presentation,
                'submission_status_id' => 26,
            ]);
        }elseif($lastSubmission->submission_status_id == 27){
            JobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' => $lastSubmission->academic_year_id,
                'submission_status_id' => 27,
            ])->update([
                'report_of_presentation'=>$this->report_of_presentation,
                'notes'=>$this->notes,
                'report_revision'=>$this->report_revision,
                'screenshot_after_presentation'=>$this->screenshot_after_presentation,
                'submission_status_id' => 26,
            ]);
        }
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil mengajukan berkas',
            'text'=>'',
        ]);
        return redirect('/dashboard');
    }

    public function render()
    {
        return view('livewire.student.after-presentation');
    }
}
