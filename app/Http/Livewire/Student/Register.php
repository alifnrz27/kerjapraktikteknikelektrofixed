<?php

namespace App\Http\Livewire\Student;

use App\Http\Livewire\User;
use App\Models\AcademicYear;
use App\Models\JobTraining;
use App\Models\SubmissionStatus;
use App\Models\User as ModelsUser;
use Livewire\Component;

class Register extends Component
{
    public $submissionStatus, $descriptionSubmissionStatus;
    protected $listeners = ['cancel'];
    public function mount()
    {
        // jika yang masuk selain student
        if(auth()->user()->role_id != 3 || auth()->user()->active_id == 0){
            return abort(403);
        }

        $academicYear = AcademicYear::where(['is_active' => 1])->first();

        $this->submissionStatus = JobTraining::where(['user_id' => auth()->user()->id])->latest()->first();

        if($this->submissionStatus){
            $this->submissionStatus = $this->submissionStatus->submission_status_id;

            $this->descriptionSubmissionStatus = SubmissionStatus::where('id', $this->submissionStatus)->first();
        }

        if($this->submissionStatus == 30 && auth()->user()->active_id == 1){
            $this->submissionStatus = Null;
        }
    }

    public function confirmCancel(){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Yakin ingin membatalkan pengajuan?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>'',
            'useMethod'=>'cancel',
        ]);


    }

    public function cancel(){
        $lastSubmission = JobTraining::where('user_id', auth()->user()->id)->latest()->first();

        // jika pengajuan individu
        if($lastSubmission->team_id == 0){
            JobTraining::where('id', $lastSubmission->id)
        ->update(['submission_status_id' => 6]);
        ModelsUser::where('id', auth()->user()->id)->update(['inviteable'=>1]);
        }
        // kalo dia berkelompok
        else {
            JobTraining::where('team_id', $lastSubmission->team_id)
            ->update(['submission_status_id' => 7]);
            $allSubmissions = JobTraining::where('team_id', $lastSubmission->team_id)->get();
            foreach($allSubmissions as $submission){
                User::where('id', $submission->user_id)->update(['inviteable'=>1]);
            }
        }

        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil membatalkan pengajuan KP tim',
            'text'=>'',
        ]);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.student.register');
    }
}
