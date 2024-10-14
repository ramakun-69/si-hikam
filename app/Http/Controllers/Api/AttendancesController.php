<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Events\AttendanceCheckedIn;
use App\Events\AttendanceCheckedOut;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendancesResource;
use App\Repositories\Attendance\AttendanceRepository;



class AttendancesController extends Controller
{
    use ResponseOutput;
    protected $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }


    public function attendances($nip)
    {

        return $this->safeExecute(function () use ($nip) {
            $attendances = new AttendancesResource($nip);
            return $this->responseSuccess($attendances);
        });
    }
    public function scan(Request $request)
    {
        return $this->safeExecute(function () use ($request) {
            $result =   $this->attendanceRepository->scan($request);
            if ($result['status']) {
                if (is_null($result['attendance']['clock_out'])) {
                    broadcast(new AttendanceCheckedIn($result))->toOthers();
                    $message = $result['attendance']['late']
                        ? __("Successful Presence (Late)")
                        : __("Successful Presence");
                } else {
                    broadcast(new AttendanceCheckedOut($result))->toOthers();
                    $message = __("Successful Return Attendance");
                }
                return $this->responseSuccess(['message' => $message]);
            }
            return $this->responseFailed($result['message']);
        });
    }

    public function dailyAttendances($nip)
    {
        return $this->safeExecute(function() use($nip){
            
        });
    }
}
