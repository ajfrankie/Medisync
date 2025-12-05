<?php


namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\AppointmentRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $countDoctors = $this->countDoctors();
        $countPatients = $this->countPatients();
        $countNurses = $this->countNurses();
        $countAdmins = $this->countAdmins();

        $appointmentsPercentage = $this->appointmentsPercentage();
        $cancelledAppoinmentPercentage = $this->cancelledAppoinmentPercentage();
        $pendingAppoinmentPercentage = $this->pendingAppoinmentPercentage();

        return view('backend.dashboard.admin_dashboard', [
            "countDoctors" => $countDoctors,
            "countPatients" => $countPatients,
            "countNurses" => $countNurses,
            "countAdmins" => $countAdmins,
            "appointmentsPercentage" => $appointmentsPercentage,
            "cancelledAppoinmentPercentage" => $cancelledAppoinmentPercentage,
            "pendingAppoinmentPercentage" => $pendingAppoinmentPercentage,
            "request" => $request,
        ]);
    }

    public function countDoctors()
    {
        return DB::table('users')->where('role_id', '=', 1)->count();
    }

    public function countPatients()
    {
        return DB::table('users')->where('role_id', '=', 2)->count();
    }

    public function countNurses()
    {
        return DB::table('users')->where('role_id', '=', 3)->count();
    }

    public function countAdmins()
    {
        return DB::table('users')->where('role_id', '=', 4)->count();
    }

    public function appointmentsPercentage()
    {
        $count = app(AppointmentRepository::class)->countAppointments();
        $completedCount = app(AppointmentRepository::class)->countCompletedAppointments();

        $percentage = $count > 0 ? ($completedCount / $count) * 100 : 0;

        return round($percentage, 2);
    }

    public function cancelledAppoinmentPercentage()
    {
        $count = app(AppointmentRepository::class)->countAppointments();
        $CancelledCount = app(AppointmentRepository::class)->countCancelledAppoinments();

        $percentage = $count > 0 ? ($CancelledCount / $count) * 100 : 0;

        return round($percentage, 2);
    }

    public function pendingAppoinmentPercentage()
    {
        $count = app(AppointmentRepository::class)->countAppointments();
        $PendingCount = app(AppointmentRepository::class)->countPendingAppoinments();

        $percentage = $count > 0 ? ($PendingCount / $count) * 100 : 0;

        return round($percentage, 2);
    }
}
