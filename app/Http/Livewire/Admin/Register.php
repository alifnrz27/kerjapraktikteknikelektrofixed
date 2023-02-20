<?php

namespace App\Http\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\JobTraining;
use App\Models\User;
use Livewire\Component;

class Register extends Component
{
    public $submissions, $description;
    protected $listeners = ['accept', 'decline'];

    public function mount(){
        $academicYear = AcademicYear::where(['is_active' => 1])->first();
        $this->submissions = JobTraining::where([
            'submission_status_id' => 9,
            'academic_year_id' => $academicYear->id,
        ])->with(['user'])->get();
        }

    public function acceptConfirm(User $user, JobTraining $submission){
        $data = [$user, $submission];
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Terima berkas?",
            'text' => '',
            'confirmButtonText' => 'Terima',
            'useMethod'=>'accept',
            'key' =>$data,
        ]);
    }

    public function accept($data){
        $user = (object)$data[0];
        $submission = (object)$data[1];

        // cek apakah ada submissionnya, takutnya malah diubah di inspect elemen
        $checkSubmission = JobTraining::where([
            'user_id' => $user->id,
            'id' => $submission->id,
            'submission_status_id' => 9, //status sedang mengajukan
        ])->first();

        if(!$checkSubmission){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan!',
                'text'=>'',
            ]);

            return;
        }

        // jika dia tidak berkelompok ubah status menjadi diterima
        if($submission->team_id == 0){
            JobTraining::where([
                'id' => $submission->id
            ])->update([
                'submission_status_id' => 10
            ]);
        }
        
        // jika berkelompok ubah status menjadi menunggu anggota lain di acc
        else{
            JobTraining::where([
                'id' => $submission->id
            ])->update([
                'submission_status_id' => 11
            ]);

            // cek jika seluruh anggota sudah di acc
            $teamSubmissions = JobTraining::where([
                'team_id' => $submission->team_id
            ])->get();
            $waitingTeam = false;
            foreach($teamSubmissions as $submission){
                if($submission->submission_status_id == 9){
                    $waitingTeam = true;
                }
            }
            if($waitingTeam == false){
                JobTraining::where([
                    'team_id' => $submission->team_id,
                    'submission_status_id' => 11
                ])->update([
                    'submission_status_id' => 10
                ]);
            }
        }

        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menerima berkas',
            'text'=>'',
        ]);
    }

    public function declineConfirm(User $user, JobTraining $submission){
        $rules = [
            'description' => 'required',
        ];

        $this->validate($rules);

        $data = [$user, $submission];
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Tolak Berkas?",
            'text' => '',
            'confirmButtonText' => 'Tolak',
            'useMethod'=>'decline',
            'key' =>$data,
        ]);
    }

    public function decline($data){
        $user = (object)$data[0];
        $submission = (object)$data[1];
        // cek apakah ada submissionnya, takutnya malah diubah di inspect elemen
        $checkSubmission = JobTraining::where([
            'id' => $submission->id,
            'user_id' => $user->id,
            'submission_status_id' => 9, //status sedang mengajukan
        ])->first();

        if(!$checkSubmission){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan!',
                'text'=>'',
            ]);

            return;
        }

        // jika dia tidak berkelompok ubah status menjadi ditolak admin
        if($submission->team_id == 0){
            JobTraining::where([
                'id' => $submission->id
                ])->update([
                    'submission_status_id' => 8,
                    'description' => $this->description,
                ]);
            User::where([
                    'id' => $submission->user_id
                    ])->update([
                        'inviteable' => 1,
                    ]);
        }

        // jika berkelompok ubah status menjadi ditolak beramai ramai
        else{
                // mendapatkan id masing masing anggota
                $members = JobTraining::select('user_id')
                ->where([
                    ['team_id', '=', $submission->team_id],
                    ['submission_status_id', '!=', 3],
                ])->get();
                $userID = [];
                for($i = 0; $i < count($members); $i++){
                    $userID[$i] = $members[$i]['user_id'];
                }

                User::whereIn('id', $userID)
                ->update([
                    'inviteable'=> 1
                ]);

            JobTraining::where([
                ['team_id', '=', $submission->team_id],
                ['submission_status_id', '!=', 3],
            ])->update([
                'submission_status_id' => 8,
                'description' => $this->description,
            ]);
        }

        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menolak berkas',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.register');
    }
}
