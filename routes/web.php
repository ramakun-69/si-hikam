<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Leave\TypeOfLeaveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});





Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('leave-request/type-of-leave', TypeOfLeaveController::class);
    Route::resource('user', UserController::class);
    Route::get('attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::get('/attendance/check-in/get-qr', [AttendanceController::class, 'getQr'])->name('get-qr');
   
});