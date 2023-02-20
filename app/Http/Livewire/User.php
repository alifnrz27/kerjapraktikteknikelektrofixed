<?php

namespace App\Http\Livewire;

use App\Models\JobTraining;
use App\Models\Mentoring;
use App\Models\Report;
use App\Models\Role;
use App\Models\Team;
use App\Models\Title;
use App\Models\User as ModelUser;
use Livewire\Component;

class User extends Component
{
    public $users, $roles, $role_id;
    protected $listeners = ['delete'];
    public function mount(){
        if(auth()->user()->role_id != 1){
            return abort(403);
        }

        $this->users = ModelUser::where([
            ['email', '!=', 'admin@el.itera.ac.id'],
            ['active_id', '!=', 0]
        ])->with(['role'])->latest()->get();

        $this->roles = Role::get();

    }

    public function deleteConfirm($username){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Yakin ingin blokir?",
            'text' => '',
            'confirmButtonText' => 'Blokir',
            'method'=>'delete',
            'key' =>$username,
        ]);
    }

    public function delete(ModelUser $user){
        $Submissions = JobTraining::where(['user_id' => $user->id])->get();

        foreach($Submissions as $s){
            if($s->team_id != 0){
                $memberTeam = JobTraining::where(['team_id' => $s->team_id])->first();
                Team::where(['id' => $s->team_id])->update([
                    'user_id' => $memberTeam->user_id
                ]);
            }
        }

        $user->update([
            'active_id'=>0,
            'inviteable' => 0
        ]);

        JobTraining::where([
            'user_id' => $user->id
        ])->delete();

        Mentoring::where([
            'student_id' => $user->id
        ])->delete();

        Report::where([
            'student_id' => $user->id
        ])->delete();

        Title::where([
            'student_id' => $user->id
        ])->delete();

        $this->mount();
    }

    public function updateRole(ModelUser $user){
        $this->validate([
            'role_id' => 'required'
        ]);

        $user->update([
            'role_id' => $this->role_id
        ]);

        $this->mount();

        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil update role '.$user->name,
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.user');
    }
}
