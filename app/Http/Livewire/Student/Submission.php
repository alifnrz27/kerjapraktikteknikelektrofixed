<?php

namespace App\Http\Livewire\Student;

use App\Models\AcademicYear;
use App\Models\JobTraining;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;

class Submission extends Component
{
    public $form, $vaccine, $name_leader, $address, $number, $transcript, $place, $start, $end, $teamStatus, $members;
    protected $listeners = ['store'];
    public function confirmStore(){
        $rules = [
            'form' => 'required',
            'vaccine' => 'required',
            'name_leader' => 'required',
            'address' => 'required',
            'number' => 'required',
            'transcript' => 'required',
            'place' => 'required',
            'start' => 'required',
            'end' => 'required',
        ];
        if($this->teamStatus == 'on'){
            $rules['members'] = 'required';
        }   

        $this->validate($rules);
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Yakin ingin menambahkan?",
            'text' => '',
            'confirmButtonText' => 'Tambah',
            'key' =>'',
            'useMethod'=>'store',
        ]);


    }
    public function store(){
        $submissionStatus = 9;
        $teamID = 0;
        $academicYear = AcademicYear::where('is_active', 1)->first();
        if(!$academicYear){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Belum ada tahun ajaran, hubungi admin untuk mengaktifkan',
                'text'=>'',
            ]);
            return;
        }

        // cek apakah jumlah hari awal ke akhir minus apa tidak, kalau minus gagal daftar
        $dateStart = strtotime($this->start);
        $dateEnd = strtotime($this->end);
        $now = strtotime('now +7 hours');
        if(($dateEnd - $dateStart) <= 0){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Tanggal yang dimasukkan salah',
                'text'=>'',
            ]);
            return;
        }

        // jika tanggal mulai ternyata sudah lewat
        if(($dateStart - $now) <= 0){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Tanggal mulai sudah lewat',
                'text'=>'',
            ]);
            return;
        }

        // jika input kurang dari 30 hari
        if(($dateEnd - $dateStart) < (strtotime('now +30 days 7 hours') - $now)){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Minimal pengajuan 30 Hari',
                'text'=>'',
            ]);
            return;
        }

        //check team member
        if ($this->teamStatus == 'on'){
            $submissionStatus = 1;
            $members = explode(' ', $this->members);
            $members = array_unique($members);
            foreach($members as $member){
                $user = User::where([
                    'username' => $member,
                    'role_id'  => 3,
                    'active_id' => 1,
                    'inviteable' =>1
                ])->first();

                // ketika tidak ada usernya
                if(!$user){
                    $this->dispatchBrowserEvent('modal', [
                        'type' => 'error',
                        'title'=> 'Anggota tim tidak ditemukan',
                        'text'=>'',
                    ]);
                    return;
                }

                // jika user menginvite diri sendiri
                if($user->username == auth()->user()->username){
                    $this->dispatchBrowserEvent('modal', [
                        'type' => 'error',
                        'title'=> 'Tidak bisa invite diri sendiri',
                        'text'=>'',
                    ]);
                    return;
                }
            }

            // isi tabel team berdasarkan id ketua tim
            Team::create([
                'user_id'=>auth()->user()->id,
            ]);
            $team = Team::where('user_id', auth()->user()->id)->latest()->first();
            $teamID = $team->id;

            // tambahkan data anggota
            foreach($members as $member){
                $user = User::where([
                    'username' => $member,
                    'role_id'  => 3,
                    'active_id' => 1,
                    'inviteable' =>1
                ])->first();
                JobTraining::create([
                    'user_id'=>$user->id,
                    'team_id'=>$team->id,
                    'name_leader' => $this->name_leader,
                    'address' => $this->address,
                    'number' => $this->number,
                    'place'=>$this->place,
                    'start'=>$this->start,
                    'end'=>$this->end,
                    'academic_year_id'=>$academicYear->id,
                    'submission_status_id'=>2,
                ]);
                User::where('username', $member)
                        ->update(['inviteable' => 0]);
            }
        }

        // isi data untuk ketua
        $validatedData = [
            'user_id'=>auth()->user()->id,
            'team_id'=>$teamID,
            'place'=>$this->place,
            'name_leader' => $this->name_leader,
            'address' => $this->address,
            'number' => $this->number,
            'start'=>$this->start,
            'end'=>$this->end,
            'form'=>$this->form,
            'vaccine'=>$this->vaccine,
            'transcript'=>$this->transcript, 
            'academic_year_id'=>$academicYear->id,
            'submission_status_id'=>$submissionStatus,
        ];
        JobTraining::create($validatedData);
        User::where('id', auth()->user()->id)
              ->update(['inviteable' => 0]);

              $this->form = '';
              $this->vaccine = ''; 
              $this->name_leader = ''; 
              $this->address = '';
              $this->number = ''; 
              $this->transcript="";
              $this->place = ''; 
              $this->start='';
              $this->end = '';
              $this->teamStatus = '';
              $this->members ='';

              $this->dispatchBrowserEvent('modal', [
                'type' => 'success',
                'title'=> 'Berhasil mengajukan KP',
                'text'=>'',
            ]);
            return redirect('/student-register');
    }
    public function render()
    {
        return view('livewire.student.submission');
    }
}
