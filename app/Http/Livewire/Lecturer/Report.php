<?php

namespace App\Http\Livewire\Lecturer;

use App\Models\Report as ModelsReport;
use Livewire\Component;

class Report extends Component
{
    public $reports, $description;
    protected $listeners = ['acceptReport', 'declineReport'];
    public function mount(){
        $this->reports = ModelsReport::where([
            'lecturer_id' => auth()->user()->id,
            'report_status_id' => 1,
        ])->with(['student'])->get();
    }

    public function confirmAcceptReport($id){
        $this->validate([
            'description' => 'required',
        ]);
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Terima?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$id,
            'useMethod'=>'acceptReport',
        ]);
    }

    public function acceptReport($id){
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = ModelsReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'report_status_id' => 1,
        ])->first();

        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        ModelsReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'report_status_id' => 1,
        ])->update([
            'report_status_id' => 3,
            'description' =>$this->description,
        ]);

        $this->description = '';
        $this->mount();

        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menerima laporan',
            'text'=>'',
        ]);
    }

    public function confirmDeclineReport($id){
        $this->validate([
            'description' => 'required',
        ]);
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Terima?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>$id,
            'useMethod'=>'declineReport',
        ]);
    }

    public function declineReport($id)
    {
        // cek apakah ada yg mengajukan, takutnya diubah ubah datanya di inspect elemen
        $check = ModelsReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'report_status_id' => 1,
        ])->first();

        if(!$check){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Data tidak ditemukan',
                'text'=>'',
            ]);
            return;
        }

        ModelsReport::where([
            'id' => $id,
            'lecturer_id' => auth()->user()->id,
            'report_status_id' => 1,
        ])->update([
            'report_status_id' => 2,
            'description' =>$this->description,
        ]);

        $this->description = '';
        $this->mount();
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Laporan berhasil ditolak',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.lecturer.report');
    }
}
