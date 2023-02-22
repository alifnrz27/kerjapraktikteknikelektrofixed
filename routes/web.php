<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Calendar;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Student\Register as StudentRegister;
use App\Http\Livewire\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('home'));
});

Route::middleware('guest')->group(function () {
    Route::get('/public/login', Login::class)
        ->name('login');

    Route::get('/public/register', Register::class)
        ->name('register');
});

Route::middleware('auth')->group(function () {
        Route::get('/public/dashboard', Dashboard::class)->name('home');
        Route::get('/public/calendar', Calendar::class)->name('calendar');
        Route::get('/public/user/profile', Profile::class)->name('profile');
        Route::get('/public/users', User::class)->name('users');
        Route::get('/public/student-register', StudentRegister::class)->name('studentRegister');

    Route::post('logout', [LogoutController::class, 'logout'])
        ->name('logout');
});

