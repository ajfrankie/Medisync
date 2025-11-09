<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role->role_name == 'Doctor') {
            return redirect()->route('admin.doctor-dashboard.index'); // e.g., DoctorDashboardController@index
        } elseif ($user->role->role_name == 'Patient') {
            return redirect()->route('admin.dashboard'); // e.g., PatientDashboardController@index
        } else {
            return redirect()->route('admin.dashboard');
        }
    }
}
