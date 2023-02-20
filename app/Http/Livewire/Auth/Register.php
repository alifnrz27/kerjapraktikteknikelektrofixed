<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\ValidEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $name = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    public function register()
    {
        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
        ]);

        // cek email itera atau bukan
        $checkEmail = explode("@", $this->email);
        $nameEmail = $checkEmail[1];
        $validateEmail = ValidEmail::where('name', $nameEmail)->first();
        if (!$validateEmail){
            $this->addError('email', 'Wajib menggunakan email ITERA');
            return;  
        }

        $username = $checkEmail[0];
        $user = User::create([
            'role_id' => 3, // secara default 3 untuk mahasiswa
            'username' => $username,
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
            'active_id' => 1, // secara default 1 untuk anggota aktif
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
