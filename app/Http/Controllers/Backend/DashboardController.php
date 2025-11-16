<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('backend.dashboard.dashboard');
    }
}
