<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendancesResource extends JsonResource
{
    protected $nip;

    public function __construct($nip)
    {
        $this->nip = $nip;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $today = Carbon::today();
        $firstDayOfMonth = $today->copy()->startOfMonth();

        $dates = collect();
        for ($date = $firstDayOfMonth->copy(); $date->lte($today); $date->addDay()) {
            if (!$date->isSunday()) {
                $dates->push($date->format('Y-m-d'));
            }
        }

        $attendances = Attendance::where('nip', $this->nip)
            ->whereBetween('date', [$firstDayOfMonth, $today])
            ->get()->keyBy('date');

        $leaveRequests = LeaveRequest::where('nip', $this->nip)
            ->whereBetween('date', [$firstDayOfMonth, $today])
            ->get()->keyBy('date');

        return $dates->map(function ($date) use ($attendances, $leaveRequests) {
            $attendance = $attendances->get($date);
            $leaveRequest = $leaveRequests->get($date);

            return [
                'date' => toDateIndo($date,true,false),
                'clock_in' => $attendance->clock_in ?? '-',
                'clock_out' => $attendance->clock_out ?? '-',
                'leave_request' => $leaveRequest ? $leaveRequest->type->name : '-',
                'status' => $this->getStatus($attendance, $leaveRequest),
            ];
        })->toArray();
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
