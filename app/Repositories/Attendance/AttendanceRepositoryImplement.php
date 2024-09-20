<?php

namespace App\Repositories\Attendance;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\QrCode;
use Carbon\Carbon;

class AttendanceRepositoryImplement extends Eloquent implements AttendanceRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }

    public function scan($request)
    {
        $qrCode = QrCode::where('data', $request->qrcode)->first();

        if (!$qrCode) {
            return ["status" => false, 'message' => __("QR Not Found")];
        }

        $today = Carbon::today();
        $attendance = Attendance::where('nip', $qrCode->nip)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            if (is_null($attendance->clock_out)) {
                $attendance->clock_out = Carbon::now()->format('H:i:s');
                $attendance->save();
                return ['status' => true, 'message' => __('Check-out successful'), 'attendance' => $attendance];
            } else {
                return ['status' => false, 'message' => __('You have already checked out today')];
            }
        } else {
            $attendance = Attendance::create([
                'nip' => $qrCode->nip,
                'date' => $today,
                'clock_in' => Carbon::now()->format('H:i:s'),
                'clock_out' => null,
                'late' => now()->greaterThan(Carbon::today()->setTime(7, 15, 0)),
            ]);

            return ['status' => true, 'attendance' => $attendance];
        }
    }
}
