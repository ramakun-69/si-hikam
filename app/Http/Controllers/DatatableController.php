<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TypeOfLeave;
use Illuminate\Http\Request;
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
}
