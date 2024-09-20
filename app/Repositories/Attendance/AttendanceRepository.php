<?php

namespace App\Repositories\Attendance;

use LaravelEasyRepository\Repository;

interface AttendanceRepository extends Repository{

    public function scan($request);

}
