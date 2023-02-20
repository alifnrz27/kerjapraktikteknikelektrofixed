<?php

namespace App\Http\Livewire\Admin;

use App\Models\JobTraining;
use Livewire\Component;

class AfterPresentation extends Component
{
    public $afterPresentations, $description, $academicYear;
    protected $listeners = ['acceptAfterPresentation', 'declineAfterPresentation'];

    public function mount($academicYear){
        $this->academicYear = $academicYear;
        $this->afterPresentations = JobTraining::where([
                'submission_status_id' => 26,
                'academic_year_id' => $academicYear->id,
            ])->with(['user'])->get();
    }

    public function acceptConfirm($studentID, $id){
        $data = [$studentID, $id];
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Terima berkas?",
            'text' => '',
            'confirmButtonText' => 'Terima',
            'useMethod'=>'acceptAfterPresentation',
            'key' =>$data,
        ]);
    }
    public function acceptAfterPresentation($data){
        $studentID = $data[0];
        $id = $data[1];
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'id' => $id,
            'user_id' => $studentID,
            'submission_status_id' => 26,
        ])->latest()->first();
        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan!',
                'text'=>'',
            ]);

            return;
        }

        JobTraining::where([
            'user_id' => $studentID,
            'submission_status_id' => 26,
        ])->update([
            'submission_status_id' => 28,
        ]);

        $this->mount($this->academicYear);
        $this->description = '';
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menerima berkas',
            'text'=>'',
        ]);
    }

    public function declineConfirm($studentID, $id){
        $rules = [
            'description' => 'required',
        ];

        $this->validate($rules);

        $data = [$studentID, $id];
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Tolak Berkas?",
            'text' => '',
            'confirmButtonText' => 'Tolak',
            'useMethod'=>'declineAfterPresentation',
            'key' =>$data,
        ]);
    }

    public function declineAfterPresentation($data){
        $studentID = $data[0];
        $id = $data[1];
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'id' => $id,
            'user_id' => $studentID,
            'submission_status_id' => 26,
        ])->latest()->first();
        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan!',
                'text'=>'',
            ]);

            return;
        }

        JobTraining::where([
            'user_id' => $studentID,
            'submission_status_id' => 26,
        ])->update([
            'submission_status_id' => 27,
            'description' =>$this->description,
        ]);

        $this->mount($this->academicYear);
        $this->description = '';
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menolak berkas',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.after-presentation');
    }
}
