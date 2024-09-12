<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    public function checkIn()
    {
        $title = __("Check In");
        return view('pages.attendances.check-in.index', compact('title'));
    }
    public function getQr()
    {
        $today = Carbon::today()->format('Y-m-d');
        $employees = Employee::whereDoesntHave('attendances', function ($query) use ($today) {
            $query->whereDate('date', $today);
        })->whereDoesntHave('leaveRequest', function ($query) use ($today) {
            $query->whereDate('date', $today);
        })->get();
        // dd($employees);
        $employees->map(function ($user) {
            $user->qrCode->data = QrCode::size(200)
               
                ->color(0, 0, 0)
                ->margin(1)
                ->generate($user->qrcode);
            return $user;
        });

        $qr = view('pages.attendances.check-in.qr-code', compact('employees'))->render();
        return response()->json($qr);
    }

    public function show()
    {
        $users = User::all();
    }
}
