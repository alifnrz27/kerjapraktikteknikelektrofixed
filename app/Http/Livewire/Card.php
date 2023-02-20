<?php

namespace App\Http\Livewire;

use App\Models\AcademicYear;
use App\Models\JobTraining;
use App\Models\Mentoring;
use Livewire\Component;

class Card extends Component
{
    public $cards=[];
    public $textCards=[];

    public function mount($academicYear){
        $this->textCards[0] = 'Tahun Ajaran';
        $this->cards[0] = $academicYear->year;

        if(auth()->user()->role_id == 1){

            $this->textCards[1] = 'Total Mahasiswa';
            $this->cards[1] = JobTraining::where([
                'academic_year_id' => $academicYear->id,
                ['submission_status_id', '!=', 3],
                ['submission_status_id', '!=', 6],
                ['submission_status_id', '!=', 7],
                ['submission_status_id', '!=', 8],
            ])->count();
            
            $this->textCards[2] = 'Total Mahasiswa Selesai';
            $this->cards[2] = JobTraining::where([
                ['academic_year_id', '=', $academicYear->id],
                ['submission_status_id', '!=', 3],
                ['submission_status_id', '!=', 6],
                ['submission_status_id', '!=', 7],
                ['submission_status_id', '!=', 8],
                ['submission_status_id', '>=' , 30]
            ])->count();

            $this->textCards[3] = 'Total Mahasiswa Daftar';
            $this->cards[3] = JobTraining::where([
                ['academic_year_id', '=', $academicYear->id],
                ['submission_status_id', '!=', 3],
                ['submission_status_id', '!=', 6],
                ['submission_status_id', '!=', 7],
                ['submission_status_id', '!=', 8],
                ['submission_status_id', '<=' , 13]
            ])->count();
        }

        elseif(auth()->user()->role_id == 2){
            
            $this->textCards[1] = 'Total Mahasiswa';
            $this->cards[1] = JobTraining::where([
                'academic_year_id' => $academicYear->id,
                'lecturer_id' => auth()->user()->id
            ])->count();

            $this->textCards[2] = 'Total Antri Presentasi';
            $this->cards[2] = JobTraining::where([
                'lecturer_id' => auth()->user()->id,
                'submission_status_id' => 23,
            ])->count();

            $this->textCards[3] = 'Total Antri Bimbingan';
            $this->cards[3] = Mentoring::where([
                'lecturer_id' => auth()->user()->id,
                'mentoring_status_id' => 3,
            ])->count();
        }

        elseif(auth()->user()->role_id == 3){
            $submission = JobTraining::where(['user_id' => auth()->user()->id])->with(['lecturer'])->latest()->first();
            
            $this->textCards[3] = 'Status';
            $this->textCards[2] = 'Tanggal Presentasi';
            $this->textCards[1] = 'Dosen Pembimbing';

            if($submission){
                $this->cards[3] = $submission->submissionStatus->name;
                if($submission->lecturer_id){
                    $this->cards[1] = $submission->lecturer->name;
                }else{
                    $this->cards[1] = '-';
                }
    
                if($submission->date_presentation){
                    $this->cards[2] = $submission->date_presentation;
                }else{
                    $this->cards[2] = '-';
                }
            }else{
                $this->cards[1] = '-';
                $this->cards[2] = '-';
                $this->cards[3] = '-';
            }
        }

        $this->cards = json_encode($this->cards);
        $this->textCards = json_encode($this->textCards);
    }

    public function render()
    {
        return view('livewire.card');
    }
}
