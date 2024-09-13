<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Events\AttendanceCheckedIn;
use App\Http\Controllers\Controller;
use App\Repositories\Attendance\AttendanceRepository;


class AttendancesController extends Controller
{
    use ResponseOutput;
    protected $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function checkIn(Request $request)
    {
        return $this->safeExecute(function () use ($request) {
            $result =   $this->attendanceRepository->checkIn($request);
            if ($result['status']) {
                broadcast(new AttendanceCheckedIn($result))->toOthers();
                $message = $result['attendance']['late'] == true 
                    ? __("Successful Presence (Late)") 
                    : __("Successful Presence");
                return $this->responseSuccess(['message' => $message]);
            }
            return $this->responseFailed($result['message']);
        });
    }






    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
