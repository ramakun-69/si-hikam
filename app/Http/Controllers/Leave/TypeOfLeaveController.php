<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\TypeOfLeaveRequest;
use App\Models\TypeOfLeave;
use App\Repositories\App\AppRepository;
use App\Traits\ResponseOutput;

class TypeOfLeaveController extends Controller
{
    use ResponseOutput;
    protected $appRepository;

    public function __construct(AppRepository $appRepository) {
        $this->appRepository = $appRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = __("Type Of Leave");
        return view("pages.leave-request.type-of-leave.index", compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeOfLeaveRequest $request)
    {
       return $this->safeExecute(function() use($request){
            $data = $request->validated();
            $model = new TypeOfLeave();
        if ($data['id']) {

            $this->appRepository->updateOneModel($model,$data);
            return $this->responseSuccess(['message' =>  __("Data Updated Successfully")]);
        } else {

            $this->appRepository->insertOneModel($model, $data);
            return $this->responseSuccess(['message' => __("Data Added Successfully")]);
        }
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
     * Show the form for editing the specified resource.
     */
    public function edit(TypeOfLeave $type_of_leave)
    {
        return $this->safeExecute(function() use($type_of_leave){
            return $this->responseSuccess($type_of_leave);
        });
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
    public function destroy(TypeOfLeave $type_of_leave)
    {
        return $this->safeExecute(function() use($type_of_leave){
            $this->appRepository->deleteOneModel($type_of_leave);
            return $this->responseSuccess(['message' => __('Data Deleted Successfully')]);
        });
    }
}
