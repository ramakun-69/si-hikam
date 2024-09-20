<?php

use App\Http\Controllers\Api\AttendancesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LeaveController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    // Route::post('/scan-qr-api', [AttendancesController::class, 'storeScan'])->name('storeScan');
    // Route::get('/get-attendance', [AttendancesController::class, 'listAttendance'])->name('listAttendance');
    // Route::get('/attendances', [AttendancesController::class, 'showAttendances'])->name('showAttendances');
    // Route::post('/permissions', [PermissionsController::class, 'store'])->name('storePermission');
    // Route::get('/permission-type', [PermissionsTypeController::class, 'show'])->name('showTypePermission');

    Route::get('leave-request/type-of-leave', [LeaveController::class, 'typeOfLeave']);
    Route::post('leave-request/store', [LeaveController::class, 'store']);
    Route::post('attendance/scan', [AttendancesController::class, 'scan']);
});

Route::post('/authenticate', [AuthController::class, 'authenticate'])->middleware('guest')->name('api.authenticate');
