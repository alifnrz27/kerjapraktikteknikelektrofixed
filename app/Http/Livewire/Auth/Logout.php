<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    protected $listeners = ['logoutUser'];
    public function logoutConfirm(){
        $this->dispatchBrowserEvent('confirm', [
            'type' => 'warning',
            'title' => "Anda yakin ingin keluar?",
            'text' => '',
            'confirmButtonText' => 'Ya',
            'key' =>'',
            'useMethod'=>'logoutUser',
        ]);
    }

    public function logoutUser(){
        Auth::logout();

        return redirect(route('home'));
    }
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
