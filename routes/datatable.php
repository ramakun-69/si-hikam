<?php

use App\Http\Controllers\DatatableController;
use Illuminate\Support\Facades\Route;

Route::prefix('datatable')->name('datatable.')->controller(DatatableController::class)->group(function () {
    Route::get('type-of-leave', 'typeOfLeave')->name('type-of-leave');
    Route::get('users', 'users')->name('users');
    Route::get('dailyAttendances', 'dailyAttendances')->name('attendances.daily');
    Route::get('leave-request', 'leaveRequest')->name('leave-request.list');
});