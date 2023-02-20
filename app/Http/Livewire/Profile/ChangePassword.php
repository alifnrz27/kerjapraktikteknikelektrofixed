<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{
    public $old_password, $new_password, $confirm_password;
    protected $listeners = ['changePassword'];
    public function confirmChangePassword(){
        $this->validate([
            'old_password'=>'required',
            'new_password'=>'required|min:8|same:confirm_password',
        ]);

        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Ganti Password?",
            'text' => '',
            'confirmButtonText' => 'Kirim',
            'key' =>'',
            'useMethod'=>'changePassword',
            ]);
    }   

    public function changePassword(){
        $user = User::where(['id' => auth()->user()->id])->first();
        if(!password_verify($this->old_password, $user->password)){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Password lama tidak sesuai',
                'text'=>'',
            ]);
            return;
        }

        if($this->old_password == $this->new_password){
            $this->dispatchBrowserEvent('modal', [
                'type' => 'error',
                'title'=> 'Password baru tidak boleh sama dengan password lama',
                'text'=>'',
            ]);
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->old_password ='';
        $this->new_password ="";
        $this->confirm_password='';
        $this->dispatchBrowserEvent('modal', [
            'type' => 'success',
            'title'=> 'Berhasil ubah password',
            'text'=>'',
        ]);
    }

    public function render()
    {
        return view('livewire.profile.change-password');
    }
}
