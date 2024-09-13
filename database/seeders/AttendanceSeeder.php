<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{

    public function run(): void
    {
        Attendance::create([
            'tanggal' => date('Y-m-d'),
            'datang' => Carbon::now()->format('H:i:s'),
            'pulang' => Carbon::now()->format('H:i:s'),
            'user_id' => 1,
            'terlambat' => false
        ]);
    }
}
