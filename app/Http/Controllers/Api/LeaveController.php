<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\TypeOfLeave;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\LeaveRequest;
use App\Http\Resources\TypeOfLeaveResource;
use App\Models\LeaveRequest as ModelsLeaveRequest;

class LeaveController extends Controller
{
    use ResponseOutput;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeaveRequest $request)
    {
        return $this->safeExecute(function () use ($request) {
            $data = $request->validated();
            $data['date'] = Carbon::today();
            $data['time'] = Carbon::now()->format('H:i:s');
            $existingLeave = ModelsLeaveRequest::where('nip', $data['nip'])
                ->whereDate('date', Carbon::today())
                ->exists();
            if ($existingLeave) {
                return $this->responseFailed(__("You have already submitted a leave request today."));
            }
            ModelsLeaveRequest::create($data);
            return $this->responseSuccess(['error' => __("Leave Request Created Successfully")]);
        });
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

    public function typeOfLeave()
    {
        return $this->safeExecute(function () {
            $typeOfLeave = TypeOfLeaveResource::collection(TypeOfLeave::all());
            return $this->responseSuccess($typeOfLeave);
        });
    }
}
