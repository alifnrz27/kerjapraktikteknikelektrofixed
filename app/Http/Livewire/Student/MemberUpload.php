<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use Livewire\Component;

class MemberUpload extends Component
{
    public $form, $vaccine, $transcript;
    protected $listeners = ['memberUpload'];

    public function confirmMemberUpload(){
        $rules = [
            'form' => 'required',
            'vaccine' => 'required',
            'transcript' => 'required',
        ];

        $this->validate($rules);
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Yakin ingin mengirim data?",
            'text' => '',
            'confirmButtonText' => 'Tambah',
            'key' =>'',
            'useMethod'=>'memberUpload',
        ]);


    }


    public function memberUpload(){
        $lastSubmission = JobTraining::where('user_id', auth()->user()->id)->latest()->first();

        JobTraining::where('id' , $lastSubmission->id)
              ->update([
                'form'=>$this->form,
                'vaccine'=>$this->vaccine,
                'transcript'=>$this->transcript,
                'submission_status_id'=>5,
            ]);

            // mengambil data submission se tim yang belum acc undangan
            $invitedSubmission = JobTraining::where(['team_id'=>$lastSubmission->team_id, 'submission_status_id' => 2])->get();

            // kalo udah gaada yg diundang lagi
            if (count($invitedSubmission) == 0){
                // ubah ketua jadi menunggu berkas seluruh anggota
                JobTraining::where(['team_id'=> $lastSubmission->team_id, 'submission_status_id'=> 1])
                        ->update(['submission_status_id' => 5]);
                // mengambil data anggota yang sudah acc tapi belum upload
                $acceptedSubmission = JobTraining::where(['team_id'=>$lastSubmission->team_id, 'submission_status_id' => 4])->get();

                // kalo yg nerima undangan pada udah upload semua
                if(count($acceptedSubmission) == 0){
                    JobTraining::where(['team_id'=> $lastSubmission->team_id, 'submission_status_id'=> 5])
                    ->update(['submission_status_id' => 9]);
                }
            }   
            $this->dispatchBrowserEvent('modal', [
                'type' => 'success',
                'title'=> 'Sukses menambahkan data',
                'text'=>'',
            ]);
            return redirect('/student-register');
    }
    public function render()
    {
        return view('livewire.student.member-upload');
    }
}
