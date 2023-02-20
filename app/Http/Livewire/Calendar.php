<?php

namespace App\Http\Livewire;

use App\Models\AcademicYear;
use App\Models\Semester;
use Livewire\Component;
use SebastianBergmann\Type\FalseType;

use function PHPUnit\Framework\isFalse;

class Calendar extends Component
{
    public $calendars, $semesters, $activeYear, $year, $semester_id;
    /** @var bool */
    public $open;

    protected $listeners = ['delete'];

    public function store()
    {
        $this->validate([
            'semester_id' =>['required'],
            'year' => ['required']
    ]);

        AcademicYear::where([
            'is_active' =>1
        ])->update([
            'is_active' =>0
        ]);

        $calendar = AcademicYear::create([
            'semester_id' => $this->semester_id,
            'year' => $this->year,
            'is_active' => 1
        ]);

        $this->open = false;
        $this->mount();

        $this->semester_id = '';
        $this->year = '';
        
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil menambahkan tahun ajaran baru',
            'text'=>'',
        ]);
    }

    public function mount(){
        if(auth()->user()->role_id != 1){
            return abort(403);
        }
        $this->calendars = AcademicYear::with(['semester'])->latest()->get();
        $this->semesters = Semester::get();
        $this->activeYear = AcademicYear::where(['is_active' => 1])->with(['semester'])->first();
    }

    public function deleteConfirm($id){
        $data = [$id];
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Yakin ingin menghapus?",
            'text' => '',
            'confirmButtonText' => 'Hapus',
            'key' =>$data,
            'useMethod'=>'delete',
        ]);
    }

    public function delete($year){
        $year = AcademicYear::where('id', $year[0])->first();
        $year->delete();

        $checkYears = AcademicYear::get();
        if(count($checkYears) > 0){
            if($year->is_active == 1){
                $latestYear = AcademicYear::latest()->first();
                $latestYear->update([
                    'is_active' => 1
                ]);
            }
        }
        $this->mount();
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
