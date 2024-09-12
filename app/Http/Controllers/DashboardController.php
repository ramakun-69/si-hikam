<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = __("Dashboard");
        return view('pages.index', compact('title'));
    }
}
