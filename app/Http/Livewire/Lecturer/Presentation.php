<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\JobTraining;
use Livewire\Component;

class Presentation extends Component
{
    public $presentations, $description, $date_presentation;
    protected $listeners = ['acceptPresentationStudent'];
    public function mount()
    {
        $this->presentations = JobTraining::where([
            'lecturer_id' => auth()->user()->id,
            'submission_status_id' => 22,
        ])->with(['user'])->get();
    }

    public function confirmAcceptPresentationStudent($studentID, $id){
        $data = [$studentID, $id];
        $this->validate([
            'date_presentation' => 'required',
            'description'=>'required',
        ]);
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Terima?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$data,
            'useMethod'=>'acceptPresentationStudent',
        ]);        
    }

    public function acceptPresentationStudent($data)
    {
        $studentID = $data[0];
        $id = $data[1];

        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'user_id' => $studentID,
            'submission_status_id' => 22,
        ])->first();
        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        JobTraining::where([
            'id' =>$id,
            'user_id' => $studentID,
            'submission_status_id' => 22,
        ])->update([
            'submission_status_id' => 23,
            'date_presentation' => $this->date_presentation,
            'description'=> $this->description,
        ]);

        $this->date_presentation = '';
        $this->description = '';
        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menerima presentasi',
            'text'=>'',
        ]);
    }
    public function render()
    {
        return view('livewire.lecturer.presentation');
    }
}
