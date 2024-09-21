<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $title = __("Leave Requests");
        return view('pages.leave-request.list.index', compact('title'));
    }
}
