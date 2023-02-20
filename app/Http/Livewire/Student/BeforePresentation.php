<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use Livewire\Component;

class BeforePresentation extends Component
{
    public $form_presentation, $result_company, $log_activity, $form_mentoring, $report,$screenshot_before_presentation, $statement_letter;
    protected $listeners = ['addBeforePresentation'];

    public function confirmAddBeforePresentation(){
        $this->validate([
            'form_presentation'=>'required',
            'result_company'=>'required',
            'log_activity'=>'required',
            'form_mentoring'=>'required',
            'report'=>'required',
            'screenshot_before_presentation'=>'required',
        ]);
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Kirim?",
            'text' => '',
            'confirmButtonText' => 'Kirim',
            'key' =>'',
            'useMethod'=>'addBeforePresentation',
        ]);
    }

    public function addBeforePresentation(){
        $lastSubmission = JobTraining::where(['user_id' => auth()->user()->id])->latest()->first();

        if($lastSubmission->submission_status_id == 19){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Menunggu pengajuan sebelumnya',
                'text'=>'',
            ]);
            return;
        }

        if($lastSubmission->submission_status_id == 18){
            JobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' =>  $lastSubmission->academic_year_id,
                'submission_status_id' => 18,
            ])->update([
                "form_presentation"=> $this->form_presentation,
                "result_company"=> $this->result_company,
                "log_activity"=> $this->log_activity,
                "form_mentoring"=> $this->form_mentoring,
                "report"=> $this->report,
                "screenshot_before_presentation"=>$this->screenshot_before_presentation,
                "statement_letter"=> $this->statement_letter,
                'submission_status_id' => 19,
            ]);
        }elseif($lastSubmission->submission_status_id == 20){
            JobTraining::where([
                'user_id' => auth()->user()->id,
                'academic_year_id' =>  $lastSubmission->academic_year_id,
                'submission_status_id' => 20,
            ])->update([
                "form_presentation"=> $this->form_presentation,
                "result_company"=> $this->result_company,
                "log_activity"=> $this->log_activity,
                "form_mentoring"=> $this->form_mentoring,
                "report"=> $this->report,
                "screenshot_before_presentation"=>$this->screenshot_before_presentation,
                "statement_letter"=> $this->statement_letter,
                'submission_status_id' => 19,
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
        return view('livewire.student.before-presentation');
    }
}
