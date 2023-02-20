<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use Livewire\Component;

class Letter extends Component
{
    public $replyFromMajor, $replyFromCompany;
    protected $listeners = ['uploadLetter'];

    public function confirmLetter(){
        $rules = [
            'replyFromMajor' => 'required',
            'replyFromCompany' => 'required',
        ];

        $this->validate($rules);
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Yakin ingin mengirim data?",
            'text' => '',
            'confirmButtonText' => 'Tambah',
            'key' =>'',
            'useMethod'=>'uploadLetter',
        ]);


    }

    public function uploadLetter(){
        $submission = JobTraining::where('user_id', auth()->user()->id)->latest()->first();

        // jika tidak ada kelompok
        if($submission->team_id == 0){
            JobTraining::where('id', $submission->id)
            ->update([
                'submission_status_id' => 12,
                'from_major' => $this->replyFromMajor,
                'from_company' => $this->replyFromCompany,
            ]);
        }

        // jika ada kelompok
        else{            
            JobTraining::where([['team_id', '=', $submission->team_id], ['submission_status_id', '!=', 3]])
            ->update([
                'submission_status_id' => 12,
                'from_major' => $this->replyFromMajor,
                'from_company' => $this->replyFromCompany,
            ]);
        }

        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil upload berkas jurusan',
            'text'=>'',
        ]);
        return redirect('/student-register');
    }
    
    public function render()
    {
        return view('livewire.student.letter');
    }
}
