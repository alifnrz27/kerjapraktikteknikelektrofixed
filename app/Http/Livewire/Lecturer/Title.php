<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\JobTraining;
use App\Models\Title as ModelsTitle;
use App\Models\TitleStatus;
use Livewire\Component;

class Title extends Component
{
    public $titles, $description;
    protected $listeners = ['acceptTitle', 'declineTitle'];
    public function mount(){
        $this->titles = ModelsTitle::where([
            'lecturer_id' => auth()->user()->id,
            'title_status_id' => 1,
        ])->with(['student'])->get();
    }


    public function confirmAcceptTitle($studentID, $id){
        $data = [$studentID, $id];
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Terima judul?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$data,
            'useMethod'=>'acceptTitle',
        ]);
    }

    public function acceptTitle($data){
        $studentID = $data[0];
        $id = $data[1];

        // cek apakah ada datanya
        $check = ModelsTitle::where([
            'id' => $id,
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'title_status_id' => 1,
        ])->first();

        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        ModelsTitle::where([
            'id' => $id,
            'student_id' => $studentID,
        ])->update([
            'title_status_id' => 3,
        ]);

        // tolak semua sisa judul
        ModelsTitle::where([
            ['student_id', '=', $studentID],
            ['title_status_id', '!=', 3]
        ])->update([
            'title_status_id' => 2,
        ]);

        // Student last submission
        $lastSubmission = JobTraining::where([
            'user_id' => $studentID,
        ])->latest()->first();

        JobTraining::where([
            'id' => $lastSubmission->id
        ])->update([
            'submission_status_id' => 18,
        ]);

        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menerima judul',
            'text'=>'',
        ]);
    }

    public function confirmDeclineTitle($studentID, $id){
        $data = [$studentID, $id];
        $this->validate([
            'description' => 'required',
        ]);

        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Tolak judul?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$data,
            'useMethod'=>'declineTitle',
        ]);
    }

    public function declineTitle($data){
        $studentID = $data[0];
        $id = $data[1];

        // cek apakah ada datanya
        $check = ModelsTitle::where([
            'id' => $id,
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
            'title_status_id' => 1,
        ])->first();

        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        ModelsTitle::where([
            'id' => $id,
            'student_id' => $studentID,
            'lecturer_id' => auth()->user()->id,
        ])->update([
            'title_status_id' => 2,
            'description' => $this->description,
        ]);

        // Student last submission
        $lastSubmission = JobTraining::where([
            'user_id' => $studentID,
        ])->latest()->first();

        $checkAllTitles = Title::where([
            'student_id' => $studentID,
            'title_status_id' => 1
        ])->get();

        if(count($checkAllTitles) == 0){
            JobTraining::where([
                'id' => $lastSubmission->id
            ])->update([
                'submission_status_id' => 17,
            ]);
        }

        $this->description = '';
        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Judul berhasil ditolak',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.lecturer.title');
    }
}
