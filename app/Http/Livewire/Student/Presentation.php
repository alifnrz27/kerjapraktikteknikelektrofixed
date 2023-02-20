<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use Livewire\Component;

class Presentation extends Component
{
    protected $listeners = ['addPresentation'];
    public function confirmAddPresentation(){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Ajukan Presentasi?",
            'text' => '',
            'confirmButtonText' => 'Ajukan',
            'key' =>'',
            'useMethod'=>'addPresentation',
        ]);
    }

    public function addPresentation(){
        $lastSubmission = JobTraining::where(['user_id' => auth()->user()->id])->latest()->first();
        JobTraining::where([
            'user_id' => auth()->user()->id,
            'academic_year_id' => $lastSubmission->academic_year_id,
            'submission_status_id' => 21,
        ])->update([
            'date_presentation'=>'-',
            'submission_status_id' => 22,
        ]);

        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil mengajukan presentasi',
            'text'=>'',
        ]);
        return redirect('/dashboard');
    }

    public function render()
    {
        return view('livewire.student.presentation');
    }
}
