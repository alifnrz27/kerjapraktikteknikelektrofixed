<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class Invitation extends Component
{
    protected $listeners = ['acceptInvitation', 'declineInvitation'];
    public function confirmAcceptInvitation(){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Yakin ingin menerima undangan?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>'',
            'useMethod'=>'acceptInvitation',
        ]);
    }

    public function confirmDeclineInvitation(){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Yakin ingin menolak undangan?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>'',
            'useMethod'=>'declineInvitation',
        ]);
    }
    public function acceptInvitation(){
        $lastSubmission = JobTraining::where(['user_id' => auth()->user()->id])->latest()->first();

        // ganti status jadi menerima undangan
        JobTraining::where('id', $lastSubmission->id)
        ->update(['submission_status_id' => 4]);

        //mendapatkan user id ketua
        $leader = Team::where('id', $lastSubmission->team_id)->first();
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
            'title'=> 'Berhasil menerima undangan',
            'text'=>'',
        ]);
        return redirect('/student-register');
    }

    public function declineInvitation(){
        $lastSubmission = JobTraining::where('user_id', auth()->user()->id)->latest()->first();

        // ganti status jadi menolak undangan
        JobTraining::where('id', $lastSubmission->id)
        ->update(['submission_status_id' => 3]);
        // ubah inviteable nya
        User::where('id', auth()->user()->id)->update(['inviteable'=>1]);
        
        //mendapatkan user id ketua
        $leader = Team::where('id', $lastSubmission->team_id)->first();
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
            'title'=> 'Berhasil menolak undangan',
            'text'=>'',
        ]);
        return redirect('/student-register');
    }
    
    public function render()
    {
        return view('livewire.student.invitation');
    }
}
