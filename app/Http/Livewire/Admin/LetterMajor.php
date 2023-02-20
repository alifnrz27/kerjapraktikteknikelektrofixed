<?php

namespace App\Http\Livewire\Admin;

use App\Models\JobTraining;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class LetterMajor extends Component
{
    public $replyLetters, $academicYear, $description;
    protected $listeners = ['acceptLetter', 'declineLetter'];

    public function mount($academicYear){
        $this->academicYear = $academicYear;
        $this->replyLetters = JobTraining::where([
            'submission_status_id' => 12,
            'academic_year_id' => $academicYear->id,
        ])->with(['user'])->get();
    }

    public function acceptConfirm(User $user, $teamID){
        $data = [$user, $teamID];
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Terima berkas?",
            'text' => '',
            'confirmButtonText' => 'Terima',
            'useMethod'=>'acceptLetter',
            'key' =>$data,
        ]);
    }

    public function acceptLetter($data){
        $user = (object)$data[0];
        $team_id = $data[1];
        // cek keberadaan data, takutnya diubah dari inspect element
        $checkLetter = JobTraining::where([
            'submission_status_id' => 12,
            'user_id' => $user->id,
            'team_id' => $team_id
        ])->latest()->first();

        if(!$checkLetter){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan!',
                'text'=>'',
            ]);

            return;
        }

        // jika tidak berkelompok
        if($checkLetter->team_id == 0){
            JobTraining::where([
                'user_id' => $checkLetter->user_id,
                'submission_status_id' => 12,
            ])->update([
                'submission_status_id' => 14,
            ]);
        }

        // jika berkelompok
        else{
            JobTraining::where([
                'team_id' => $checkLetter->team_id,
                'submission_status_id' => 12,
            ])->update([
                'submission_status_id' => 14,
            ]);
        }


        $this->mount($this->academicYear);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menerima berkas',
            'text'=>'',
        ]);

    }

    public function declineConfirm(User $user, $teamID){
        $rules = [
            'description' => 'required',
        ];

        $this->validate($rules);

        $data = [$user, $teamID];
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Tolak Berkas?",
            'text' => '',
            'confirmButtonText' => 'Tolak',
            'useMethod'=>'declineLetter',
            'key' =>$data,
        ]);
    }


    public function declineLetter($data){
        $user = (object)$data[0];
        $team_id = $data[1];
        // cek keberadaan data, takutnya diubah dari inspect element
        $checkLetter = JobTraining::where([
            'submission_status_id' => 12,
            'user_id' => $user->id,
            'team_id' => $team_id
        ])->latest()->first();

        if(!$checkLetter){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan!',
                'text'=>'',
            ]);

            return;
        }

        // jika tidak berkelompok
        if($checkLetter->team_id == 0){
            JobTraining::where([
                'user_id' => $checkLetter->user_id,
                'submission_status_id' => 12,
            ])->update([
                'submission_status_id' => 13,
                'description' => $this->description,
            ]);
        }

        // jika berkelompok
        else{
            JobTraining::where([
                'team_id' => $checkLetter->team_id,
                'submission_status_id' => 12,
            ])->update([
                'submission_status_id' => 13,
                'description' => $this->description,
            ]);
        }

        $this->mount($this->academicYear);
        $this->description ='';
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menolak berkas',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.letter-major');
    }
}
