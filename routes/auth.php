<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'auth'])->middleware('guest')->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');