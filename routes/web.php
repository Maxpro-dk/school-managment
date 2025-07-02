<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\ClassDetails;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Profile;
use App\Http\Livewire\SchoolClasses;
use App\Http\Livewire\Subjects;
use App\Http\Livewire\Students;
use App\Http\Livewire\Teachers;

use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\UserManagement;
use App\Http\Livewire\Schedules;

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
    return redirect('/dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');

    Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');
    Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/classes', SchoolClasses::class)->name('classes');
    Route::get('/class-details/{classId}', ClassDetails::class)->name('class-details');
    Route::get('/subjects', Subjects::class)->name('subjects');
    Route::get('/students', Students::class)->name('students');
    Route::get('/teachers', Teachers::class)->name('teachers');
    Route::get('/schedules', Schedules::class)->name('schedules');

    Route::get('/user-profile', UserProfile::class)->name('user-profile');
    Route::get('/user-management', UserManagement::class)->name('user-management');
});
