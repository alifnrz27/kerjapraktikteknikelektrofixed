<?php

namespace App\Http\Livewire\Student;

use App\Models\JobTraining;
use App\Models\Logbook as ModelsLogbook;
use Livewire\Component;

class Logbook extends Component
{
    public $logbooks, $date, $description;
    protected $listeners = ['addLogbook'];
    public function mount(){
        $this->logbooks = ModelsLogbook::where(['user_id' => auth()->user()->id])->latest()->get();
    }

    public function confirmAddLogbook(){
        $rules = [
            'date' => 'required',
            'description' => 'required',
        ];
        $this->validate($rules);
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Kirim?",
            'text' => '',
            'confirmButtonText' => 'Kirim',
            'key' =>'',
            'useMethod'=>'addLogbook',
        ]);
    }

    public function addLogbook(){
        $submission = JobTraining::where('user_id', auth()->user()->id)->latest()->first();
        
        $logbooks = ModelsLogbook::where(['user_id' => auth()->user()->id, 'job_training_id' => $submission->id])->get();
        if (count($logbooks) > 0){
            $countLogbook = count($logbooks);
            $logbook = $logbooks[$countLogbook-1];
        }

        $inputDate = strtotime($this->date);
        $startDate = strtotime($submission->start);
        $endDate = strtotime($submission->end);
        $now = strtotime('now +7 hours');
        
        // jika tanggal di luar rentang waktu yang ditentukan
        if ($inputDate < $startDate || $inputDate > $endDate ){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Tanggal yang dimasukkan di luar rentang',
                'text'=>'',
            ]);
            return;
        }

        // jika user memasukkan tanggal yang belum dilalui
        if($inputDate > $now){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Selesaikan harimu, baru input data',
                'text'=>'',
            ]);
            return;
        }

        // jika user belum memasukkan data sebelum hari ini
        if(count($logbooks) == 0){
            // jika user belum memasukkan sama sekali logbook, namun sudah lompat ke tanggal lain
            if($inputDate >= strtotime($submission->start . ' +1 day')){
                $this->dispatchBrowserEvent('modal', [
                    'type' => 'error',
                    'title'=> 'Hari pertama belum diisi',
                    'text'=>'',
                ]);
                return;
            }
        }
        else{
            // jika user memasukkan tanggal, namun hari sebelumnya belum diinputkan
            if($inputDate > strtotime($logbook->date . ' +1 day')){
                $this->dispatchBrowserEvent('modal', [
                    'type' => 'error',
                    'title'=> 'Isi hari sebelumnya',
                    'text'=>'',
                ]);
                return;
            }
        }

        // jika user memasukkan logbook di tanggal yang sudah diinput
        foreach($logbooks as $logbook){
            if($logbook->date == $this->date){
                $this->dispatchBrowserEvent('modal', [
                    'type' => 'error',
                    'title'=> 'Kamu sudah isi hari ini',
                    'text'=>'',
                ]);
                return;
            }
        }

        // isi tabel logbook
        Logbook::create([
            'user_id'=>auth()->user()->id,
            'job_training_id' => $submission->id,
            'date'=>$this->date,
            'description'=>$this->description
        ]);

        $this->mount();
        $this->date = '';
        $this->description = '';

        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menambahkan logbook',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.student.logbook');
    }
}
