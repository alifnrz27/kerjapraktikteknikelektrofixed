<?php

namespace App\Http\Livewire\Admin;

use App\Models\JobTraining;
use Livewire\Component;

class BeforePresentation extends Component
{
    public $beforePresentations, $academicYear, $description;
    protected $listeners = ['acceptBeforePresentation', 'declineBeforePresentation'];

    public function mount($academicYear){
        $this->academicYear = $academicYear;
        $this->beforePresentations = JobTraining::where([
                'submission_status_id' => 19,
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
            'useMethod'=>'acceptBeforePresentation',
            'key' =>$data,
        ]);
    }

    public function acceptBeforePresentation($data){
        $studentID = $data[0];
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'user_id' => $studentID,
            'submission_status_id' => 19,
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
            'submission_status_id' => 19,
        ])->update([
            'submission_status_id' => 21,
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
            'useMethod'=>'declineBeforePresentation',
            'key' =>$data,
        ]);
    }

    public function declineBeforePresentation($data){
        $studentID = $data[0];
        // cek apakah ada datanya, takutnya diubah di inspect elemen
        $check = JobTraining::where([
            'user_id' => $studentID,
            'submission_status_id' => 19,
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
            'submission_status_id' => 19,
        ])->update([
            'submission_status_id' => 20,
            'description' => $this->description
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
        return view('livewire.admin.before-presentation');
    }
}
