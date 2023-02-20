<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\JobTraining;
use Livewire\Component;

class Evaluate extends Component
{
    public $evaluates;
    protected $listeners = ['evaluated'];
    public function mount(){
        $this->evaluates = JobTraining::where([
            ['lecturer_id', '=', auth()->user()->id],
            ['submission_status_id', '>=', 24],
            ['evaluated_id', '=', 0],
        ])->with(['user'])->get();
    }

    public function confirmEvaluate($studentID, $id){
        $data = [$studentID, $id];
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Selesai?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$data,
            'useMethod'=>'evaluated',
        ]);
    }

    public function evaluated($data){
        $studentID= $data[0];
        $id= $data[1];

        $submission = JobTraining::where([
            'user_id' => $studentID,
            'id' => $id,
            'evaluated_id' => 0
        ])->latest()->first();

        if(!$submission){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        if($submission->submission_status_id == 24){
            $submission->update([
                'submission_status_id' => 25,
                'evaluated_id' => 1
        ]);
        } 
        else{
            $submission->update([
                'evaluated_id' => 1
            ]);
        }

        $this->mount();

        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Selesai',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.lecturer.evaluate');
    }
}
