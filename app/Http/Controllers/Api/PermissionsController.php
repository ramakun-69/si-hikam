<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Izin;
use Illuminate\Http\Request;
use App\Traits\ResponseOutput;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
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
    public function store(Request $request)
    {
        return $this->safeApiCall(function () use ($request) {
            $today = now()->toDateString();

            $currentTime = Carbon::now()->format('H:i:s');
            // Validasi data request
            $validator = validator($request->all(), [

                'jenis_izin' => 'required|string|max:255',
                'keterangan' => 'nullable|string',

            ]);

            if ($validator->fails()) {
                return $this->responseErrorValidate($validator->errors());
            }

            // Simpan data ke tabel izins
            $data = $validator->validated();
            // dd($data);
            $data['tanggal'] = $today; // gak perlu ambil id user karena udah di handle sama bearer token
            $data['jam'] = $currentTime; // gak perlu ambil id user karena udah di handle sama bearer token
            $data['user_id'] = $request->user()->id; // gak perlu ambil id user karena udah di handle sama bearer token
            $izin = Izin::create($data);

            // Return response success
            return $this->responseSuccess(['izin' => $izin]);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Izin $izin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Izin $izin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Izin $izin)
    {
        //
    }
}
