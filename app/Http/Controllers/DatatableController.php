<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\TypeOfLeave;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function typeOfLeave()
    {
        $data = TypeOfLeave::orderBy('name', 'asc')->get();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '
                <div class="btn-group" role="group">
                    <a href="' . route('type-of-leave.edit', $row) . '" class="btn btn-sm btn-warning edit"><i class="fas fa-edit"></i></a>
                    <a href="' . route('type-of-leave.destroy', $row) . '" class="btn btn-sm btn-danger trashed"><i class="fas fa-trash"></i></a>
                </div>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
    public function users()
    {
        $data = User::whereRole('employee')
            ->whereHas('employee', function ($query) {
                $query->orderBy('name', 'asc');
            })
            ->with('employee')->get();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '
                <div class="btn-group" role="group">
                    <a href="' . route('user.edit', $row) . '" class="btn btn-sm btn-warning edit"><i class="fas fa-edit"></i></a>
                    <a href="' . route('user.destroy', $row) . '" class="btn btn-sm btn-danger trashed"><i class="fas fa-trash"></i></a>
                </div>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }

    public function dailyAttendances()
    {
        $today = Carbon::today();
        $employees = Employee::with(['attendances' => function ($query) use ($today) {
            $query->whereDate('date', $today);
        }, 'leaveRequests' => function ($query) use ($today) {
            $query->whereDate('date', $today);
        }])->get();
        // dd($employees);
        return DataTables::of($employees)
            ->editColumn('clock_in', function ($employee) {
                $attendance = $employee->attendances->first();
                return $attendance ? $attendance->clock_in : '-';
            })
            ->editColumn('leave_request', function ($employee) {
                $leaveRequest = $employee->leaveRequests->first();
                return $leaveRequest ? $leaveRequest->type->name : '-';
            })
            ->addColumn('clock_out', function ($employee) {
                $attendance = $employee->attendances->first();
                return $attendance ? $attendance->clock_out : '-';
            })
            ->addColumn('name', function ($employee) {
                return $employee->name;
            })
            ->addIndexColumn()
            ->toJson();
    }
    public function leaveRequest()
    {
        $leaveRequest = LeaveRequest::with('employee')->get();
        // dd($employees);
        return DataTables::of($leaveRequest)
            ->addColumn('employee', function($row){
                return $row->employee->name;
            })
            ->addColumn('type', function($row){
                return $row->type->name;
            })
            ->addColumn('date', function($row){
                return toDateIndo($row->date);
            })
            ->addIndexColumn()
            ->toJson();
    }
}
