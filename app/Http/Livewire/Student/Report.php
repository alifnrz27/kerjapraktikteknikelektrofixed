<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use App\Models\Report as ModelsReport;
use App\Models\ReportStatus;
use Livewire\Component;

class Report extends Component
{
    public $submissionStatus, $reports, $reportStatus, $report;
    protected $listeners = ['addReport'];
    public function mount($submissionStatus){
        $this->submissionStatus = $submissionStatus;
        $this->reports = ModelsReport::where(['student_id' => auth()->user()->id])->latest()->get();
        $this->reportStatus = ReportStatus::get();
    }

    public function confirmAddReport(){
        $this->validate([
            'report' => 'required',
        ]);

        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Ajukan laporan?",
            'text' => '',
            'confirmButtonText' => 'Ajukan',
            'key' =>'',
            'useMethod'=>'addReport',
        ]);
    }

    public function addReport(){
        // cek apakah sebelumnya pernah mengajukan
        $report = ModelsReport::where(['student_id' => auth()->user()->id, 'report_status_id' => 1])->first();
        if($report) {
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Silahkan menunggu pengajuan sebelumnya',
                'text'=>'',
            ]);
            return;
        }

        $lastSubmission = JobTraining::where([
            'user_id' => auth()->user()->id
        ])->latest()->first();

        ModelsReport::create([
            'student_id' => auth()->user()->id,
            'lecturer_id' => $lastSubmission->lecturer_id,
            'report' => $this->report,
            'academic_year_id' => $lastSubmission->academic_year_id,
            'report_status_id' => 1,
            'description'=>'-',
        ]);

        $this->report = '';
        $this->mount($this->submissionStatus);
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil mengajukan laporan',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.student.report');
    }
}
