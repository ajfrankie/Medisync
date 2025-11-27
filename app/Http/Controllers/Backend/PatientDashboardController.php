<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\AppointmentRepository;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientDashboardController extends Controller
{
    public function index(Request $request)
    {

        $AppointmentDate = $this->AppointmentDate();
        $completedAppointments = $this->completedAppointments();
        $nextAppointmentDate = $this->nextAppointmentDate();
        $cancleAppointment = $this->cancleAppointment();
        $yearAppointmetDetails = $this->yearAppointmetDetails();
        return view('backend.dashboard.patient_dashboard', [
            "AppointmentDate" => $AppointmentDate,
            "completedAppointments" => $completedAppointments,
            "nextAppointmentDate" => $nextAppointmentDate,
            "cancleAppointment" => $cancleAppointment,
            "yearAppointmetDetails" => $yearAppointmetDetails,
        ]);
    }

    public function AppointmentDate()
    {
        $user = Auth::user();
        $patient = $user->patient;

        return $patient->appointments()
            ->where('status', 'confirmed')
            ->orderBy('appointment_date', 'asc')
            ->value('appointment_date');
    }

    public function completedAppointments()
    {
        $user = Auth::user();
        $patient = $user->patient;

        return $patient->appointments()
            ->where('status', 'Completed')
            ->count();
    }

    public function nextAppointmentDate()
    {
        $user = Auth::user();
        $patient = $user->patient;

        return $patient->appointments()
            ->where('status', 'schedule next appointment')
            ->orderBy('appointment_date', 'asc')
            ->value('next_appointment_date');
    }

    public function cancleAppointment()
    {
        $user = Auth::user();
        $patient = $user->patient;

        // Get only the count of Pending appointments for the current month
        $cancleAppointment = $patient->appointments()
            ->where('status', 'Completed')
            ->count();

        return $cancleAppointment;
    }

    public function yearAppointmetDetails()
    {
        $user = Auth::user();
        $patient = $user->patient;


        $yearAppointmetDetails = $patient->appointments()
            ->select(
                DB::raw('MONTH(appointment_date) as month'),
                DB::raw('SUM(CASE WHEN status = "Completed" THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(CASE WHEN status = "Pending" THEN 1 ELSE 0 END) as pending'),
                DB::raw('SUM(CASE WHEN status = "Cancelled" THEN 1 ELSE 0 END) as cancelled'),
                DB::raw('SUM(CASE WHEN status = "Confirmed" THEN 1 ELSE 0 END) as confirmed')
            )
            ->whereYear('appointment_date', now()->year)
            ->groupBy(DB::raw('MONTH(appointment_date)'))
            ->orderBy(DB::raw('MONTH(appointment_date)'))
            ->get();

        $months = [];
        $completed = [];
        $pending = [];
        $cancelled = [];
        $confirmed = [];

        foreach (range(1, 12) as $month) {
            $data = $yearAppointmetDetails->firstWhere('month', $month);
            $months[] = date('M', mktime(0, 0, 0, $month, 1));
            $completed[] = $data->completed ?? 0;
            $pending[] = $data->pending ?? 0;
            $cancelled[] = $data->cancelled ?? 0;
            $confirmed[] = $data->confirmed ?? 0;
        }

        return [
            'months' => $months,
            'completed' => $completed,
            'pending' => $pending,
            'cancelled' => $cancelled,
            'confirmed' => $confirmed,
        ];
    }
}
