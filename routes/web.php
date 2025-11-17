<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('siswa', SiswaController::class);
// Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
// Route::post('/siswa/create', [SiswaController::class, ''])