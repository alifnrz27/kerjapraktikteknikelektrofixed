<?php

namespace App\Http\Livewire\Admin;

use App\Models\JobTraining;
use App\Models\User;
use Livewire\Component;

class Status extends Component
{

    public $status, $statusHistory, $academicYear;
    protected $listeners = ['acceptStatus', 'declineStatus', 'acceptUpdateStatus', 'declineUpdateStatus'];

    public function mount($academicYear){
        $this->academicYear = $academicYear;
        $this->status = JobTraining::where([
                    'submission_status_id' => 29,
                    'academic_year_id' => $academicYear->id,
                ])->with(['user'])->get();

        $this->statusHistory = JobTraining::where([
                    'submission_status_id' => 30,
                ])->with(['user'])->latest()->get();
    }

    public function acceptConfirm($studentID, $id){
        $data = [$studentID, $id];
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Luluskan mahasiswa?",
            'text' => '',
            'confirmButtonText' => 'Terima',
            'useMethod'=>'acceptStatus',
            'key' =>$data,
        ]);
    }

    public function acceptStatus($data){
        $studentID = $data[0];
        $id = $data[1];
         // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'user_id' => $studentID,
            'id' => $id,
            'submission_status_id' => 29,
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
            'submission_status_id' => 29,
        ])->update([
            'submission_status_id' => 30,
        ]);

        User::where([
            'id' => $studentID
        ])->update([
            'active_id' => 0
        ]);

        $this->mount($this->academicYear);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil meluluskan mahasiswa',
            'text'=>'',
        ]);
    }

    public function acceptUpdateConfirm($studentID, $id){
        $data = [$studentID, $id];
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Ubah jadi luluskan mahasiswa?",
            'text' => '',
            'confirmButtonText' => 'Terima',
            'useMethod'=>'acceptUpdateStatus',
            'key' =>$data,
        ]);
    }

    public function acceptUpdateStatus($data){
        $studentID = $data[0];
        $id = $data[1];
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'user_id' => $studentID,
            'id' => $id,
            'submission_status_id' => 30,
        ])->first();
        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan!',
                'text'=>'',
            ]);
            return;
        }

        User::where([
            'id' => $studentID
        ])->update([
            'inviteable' => 0,
            'active_id' => 0
        ]);

        $this->mount($this->academicYear);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil meluluskan mahasiswa',
            'text'=>'',
        ]);
    }

    public function declineConfirm($studentID, $id){
        $data = [$studentID, $id];
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Mahasiswa tidak lulus?",
            'text' => '',
            'confirmButtonText' => 'Tidak Lulus',
            'useMethod'=>'declineStatus',
            'key' =>$data,
        ]);
    }

    public function declineStatus($data){
        $studentID = $data[0];
        $id = $data[1];
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'user_id' => $studentID,
            'id' => $id,
            'submission_status_id' => 29,
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
            'submission_status_id' => 29,
        ])->update([
            'submission_status_id' => 30,
        ]);

        User::where([
            'id' => $studentID
        ])->update([
            'inviteable' => 1
        ]);
        $this->mount($this->academicYear);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Mahasiswa tidak lulus',
            'text'=>'',
        ]);
    }

    public function declineUpdateConfirm($studentID, $id){
        $data = [$studentID, $id];
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Batal luluskan mahasiswa?",
            'text' => '',
            'confirmButtonText' => 'Tidak Lulus',
            'useMethod'=>'declineUpdateStatus',
            'key' =>$data,
        ]);
    }

    public function declineUpdateStatus($data){
        $studentID = $data[0];
        $id = $data[1];
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'user_id' => $studentID,
            'id' => $id,
            'submission_status_id' => 30,
        ])->first();
        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan!',
                'text'=>'',
            ]);
            return;
        }

        User::where([
            'id' => $studentID
        ])->update([
            'inviteable' => 1,
            'active_id' => 1
        ]);
        $this->mount($this->academicYear);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Mahasiswa tidak lulus',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.status');
    }
}
