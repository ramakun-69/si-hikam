<?php

namespace App\Repositories\Attendance;

use LaravelEasyRepository\Repository;

interface AttendanceRepository extends Repository{

    public function checkIn($request);
    public function checkOut($request);
}
