<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PermissionType;
use App\Traits\ResponseOutput;
use App\Http\Controllers\Controller;

class PermissionsTypeController extends Controller
{
    use ResponseOutput;
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $permissionTypes = PermissionType::all();

            return $this->responseSuccess([
                'jenis_izin' => $permissionTypes
            ]);
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
