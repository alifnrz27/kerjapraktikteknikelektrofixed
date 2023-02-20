<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\Mentoring;
use Livewire\Component;

class MentoringQueue extends Component
{
    public $mentoringsQueue, $time, $description;
    protected $listeners = ['finishMentoring', 'cancelMentoring', 'updateMentoring'];
    public function mount(){
        $this->mentoringsQueue = Mentoring::where([
            'lecturer_id' => auth()->user()->id,
            'mentoring_status_id' => 3,
        ])->with(['student'])->get();
    }

    public function confirmFinishMentoring($queueID){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Selesai?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$queueID,
            'useMethod'=>'finishMentoring',
        ]);
    }

    public function finishMentoring($queueID){
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = Mentoring::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'mentoring_status_id' => 3,
        ])->first();

        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        Mentoring::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'mentoring_status_id' => 3,
        ])->update([
            'mentoring_status_id' => 4,
        ]);

        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil merubah data',
            'text'=>'',
        ]);
    }

    public function confirmCancelMentoring($queueID){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Selesai?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$queueID,
            'useMethod'=>'cancelMentoring',
        ]);
    }

    public function cancelMentoring($queueID){
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = Mentoring::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'mentoring_status_id' => 3,
        ])->first();

        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        Mentoring::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'mentoring_status_id' => 3,
        ])->update([
            'mentoring_status_id' => 2,
        ]);

        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil membatalkan bimbingan',
            'text'=>'',
        ]);
    }

    public function confirmUpdateMentoring($queueID){
        $this->validate([
            'time' => 'required',
            'description' => 'required',
        ]);

        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Update?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$queueID,
            'useMethod'=>'updateMentoring',
        ]);
    }

    public function updateMentoring($queueID){
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = Mentoring::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'mentoring_status_id' => 3,
        ])->first();

        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        Mentoring::where([
            'id' => $queueID,
            'lecturer_id' => auth()->user()->id,
            'mentoring_status_id' => 3,
        ])->update([
            'time' => $this->time,
            'description' => $this->description
        ]);

        $this->time = '';
        $this->description= '';
        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'error',
            'title'=> 'Berhasil update data',
            'text'=>'',
        ]);
    }





    public function render()
    {
        return view('livewire.lecturer.mentoring-queue');
    }
}
