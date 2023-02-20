<?php

namespace App\Http\Livewire\Admin;

use App\Models\JobTraining;
use Livewire\Component;

class HardCopy extends Component
{
    public $hardcopy, $academicYear;
    protected $listeners = ['acceptHardCopy', 'declineHardCopy'];

    public function mount($academicYear){
        $this->academicYear = $academicYear;
        $this->hardcopy = JobTraining::where([
                'submission_status_id' => 28,
                'academic_year_id' => $academicYear->id,
            ])->with(['user'])->get();
    }

    public function acceptConfirm($studentID, $id){
        $data = [$studentID, $id];
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Sudah mengumpulkan?",
            'text' => '',
            'confirmButtonText' => 'Terima',
            'useMethod'=>'acceptHardCopy',
            'key' =>$data,
        ]);
    }

    public function acceptHardCopy($data){
        $studentID = $data[0];
        $id = $data[1];
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'user_id' => $studentID,
            'id' => $id,
            'submission_status_id' => 28,
        ])->first();
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
            'submission_status_id' => 28,
        ])->update([
            'submission_status_id' => 29,
        ]);

        $this->mount($this->academicYear);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menerima berkas',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.hard-copy');
    }
}
