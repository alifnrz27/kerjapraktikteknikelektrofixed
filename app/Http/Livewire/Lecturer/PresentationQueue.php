<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\JobTraining;
use Livewire\Component;

class PresentationQueue extends Component
{
    public $presentationsQueue;
    protected $listeners = ['finishedPresentation'];
    public function mount(){
        $this->presentationsQueue = JobTraining::where([
            'lecturer_id' => auth()->user()->id,
            'submission_status_id' => 23,
        ])->with(['user'])->get();
    }

    public function confirmFinishedPresentation($studentID, $id){
        $data = [$studentID, $id];
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Selesai?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$data,
            'useMethod'=>'finishedPresentation',
        ]);        
    }

    public function finishedPresentation($data){
        $studentID = $data[0];
        $id = $data[1];
        $lastSubmission = JobTraining::where(['user_id' => $studentID, 'submission_status_id' => 23])->latest()->first();
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        if(!$lastSubmission){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        JobTraining::where([
            'user_id' => $studentID,
            'submission_status_id' => 23,
        ])->update([
            'submission_status_id' => 24,
        ]);

        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menyelesaikan presentasi',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.lecturer.presentation-queue');
    }
}
