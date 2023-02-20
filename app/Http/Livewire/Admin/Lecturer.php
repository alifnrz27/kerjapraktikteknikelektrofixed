<?php

namespace App\Http\Livewire\Admin;

use App\Models\JobTraining;
use App\Models\User;
use Livewire\Component;

class Lecturer extends Component
{
    public $lecturer, $lecturerHistory, $mentors, $mentor, $academicYear;

    protected $listeners = ['acceptMentor', 'updateMentor'];

    public function mount($academicYear){
        $this->academicYear = $academicYear;
        $this->lecturer = JobTraining::where([
                    'submission_status_id' => 14,
                    'academic_year_id' => $academicYear->id,
                ])->with(['user'])->get();

        $this->lecturerHistory = JobTraining::where([
                    ['submission_status_id', '>=', 15],
                    ['academic_year_id' ,'=', $academicYear->id],
                ])->with(['user'])->latest()->get();

        $this->mentors = User::where([
                    'role_id' => 2,
                    'active_id' => 1
                ])->get();
    } 

    public function acceptConfirmLecturer($username){
        $rules = [
            'mentor' => 'required',
        ];

        $this->validate($rules);
        $data = $username;
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Pilih dosen?",
            'text' => '',
            'confirmButtonText' => 'Terima',
            'useMethod'=>'acceptMentor',
            'key' =>$data,
        ]);
    }

    public function acceptMentor($student){
        // cek apakah dosen ada, takutnya diubah di inspect elemen
        $mentor = User::where(['username' => $this->mentor, 'role_id' => 2, 'active_id' => 1])->first();
        // cek apakah dosen ada, takutnya diubah di inspect elemen
        $student = User::where(['username' => $student, 'role_id' => 3, 'active_id' => 1])->first();
            
        $this->validate(['mentor' => 'required']);
        // cek apakah benar student belum mendapatkan mentor
        $submission = JobTraining::where([
            'user_id' => $student->id,
            'submission_status_id' => 14,
        ])->latest()->first();

        
        if(!$mentor || $student->role_id != 3 || $student->active_id != 1){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'User tidak ditemukan!',
                'text'=>'',
            ]);

            return;
        }

        

        if(!$submission){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan!',
                'text'=>'',
            ]);
            return;
        }

        JobTraining::where([
            'user_id' => $student->id,
            'submission_status_id' => 14,
        ])->update([
            'submission_status_id'=>15,
            'lecturer_id' => $mentor->id,
        ]);

        $this->mount($this->academicYear);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil update dospem',
            'text'=>'',
        ]);
    }

    public function updateConfirm($student, $id){
        $rules = [
            'mentor' => 'required',
        ];

        $this->validate($rules);
        $data = [$student, $id];
        
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'question',
            'title' => "Update dosen?",
            'text' => '',
            'confirmButtonText' => 'Terima',
            'useMethod'=>'updateMentor',
            'key' =>$data,
        ]);
    }

    public function updateMentor($data){
        $student = $data[0];
        $id = $data[1];
        // cek apakah dosen dan mahasiswa ada, takutnya diubah di inspect elemen
        $mentor = User::where(['username' => $this->mentor, 'role_id' => 2, 'active_id' => 1])->first();
        $student = User::where(['username' => $student, 'role_id' => 3, 'active_id' => 1])->first();

        
        // cek apakah benar student sudah mendapatkan mentor
        $submission = JobTraining::where([
            'user_id' => $student->id,
        ])->latest()->first();

        if(!$mentor || !$student || !$submission){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'User tidak ditemukan!',
                'text'=>'',
            ]);
            return;
        }

        // cek apakah ada student dan mentor di semester yang sama
        $checkMentor = JobTraining::where(['user_id' => $student->id, 
        'lecturer_id' => $mentor->id,
        'id' => $id])->first();
        if($checkMentor){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data sudah ada!',
                'text'=>'',
            ]);
            return;
        }

        // jika ada maka ubah data mentornya
        JobTraining::where([
            'user_id' => $student->id, 
            'id' => $id,
            ])->update(['lecturer_id' => $mentor->id]);

            $this->dispatchBrowserEvent('modal', [
                'type' => 'success',
                'title'=> 'Berhasil update dospem',
                'text'=>'',
            ]);
    
    }

    public function render()
    {
        return view('livewire.admin.lecturer');
    }
}
