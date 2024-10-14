<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyAttendancesResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $today = Carbon::today();

        // Mengambil absensi hari ini dan membuat key berdasarkan date
        $attendances = Attendance::where('nip', $this->nip)
            ->whereDate('date', $today)
            ->get()->keyBy('date');

        // Mengambil leave request hari ini dan membuat key berdasarkan date
        $leaveRequests = LeaveRequest::where('nip', $this->nip)
            ->whereDate('date', $today)
            ->get()->keyBy('date');

        // Ambil attendance untuk hari ini dari koleksi
        $attendance = $attendances->get($today->toDateString());
        $leaveRequest = $leaveRequests->get($today->toDateString());

        return [
            'date' => toDateIndo($today, true, false),
            'clock_in' => $attendance->clock_in ?? '-',
            'clock_out' => $attendance->clock_out ?? '-',
            'leave_request' => $leaveRequest ? $leaveRequest->type->name : '-',
            'status' => $this->getStatus($attendance, $leaveRequest),
        ];
    }

    private function getStatus($attendance, $leaveRequest)
    {
        if ($attendance) {
            // Clock in but no clock out
            if ($attendance->clock_in && !$attendance->clock_out && $leaveRequest) {
                return __('Leave');
            } elseif ($attendance->clock_in && !$attendance->clock_out) {
                return __('Present (No Clock Out)');
            } elseif ($attendance->clock_in && $attendance->clock_out) {
                return __('Present');
            }
        } else {
            // No clock in or clock out
            return $leaveRequest ? __('Leave') : __('Absent');
        }
    }
}
