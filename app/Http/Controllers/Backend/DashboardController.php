<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('backend.dashboard.dashboard', [
            'notifications' => $this->notifications(),
            'totalPendingAppointments' => $this->totalPendingAppointments(),
            'totalCompletedAppointments' => $this->totalCompletedAppointments(),
            'totalCancledAppointments' => $this->totalCancelledAppointments(),
            'totalConfirmedAppointments' => $this->totalConfirmedAppointments(),
        ]);
    }

    /**
     * Get logged-in user role_id
     */
    public function getUserRole()
    {
        return Auth::user()->role_id;
        // 1 = Doctor 
        // 2 = Patient 
        // 3 = Admin Officer
        // 4 = Nurse
    }

    /**
     * Return appointment query based on user role
     */
    public function appointmentQuery()
    {
        $role = $this->getUserRole();
        $user = Auth::user();

        if ($role == 1 && $user->doctor) {
            // Doctor → Only doctor's appointments
            return $user->doctor->appointments();
        }

        if ($role == 2 && $user->patient) {
            // Patient → Only their appointments
            return $user->patient->appointments();
        }

        // Admin Officer + Nurse → All appointments
        return Appointment::query();
    }

    /**
     * Notifications for today
     */
    public function notifications()
    {
        return app(NotificationRepository::class)
            ->getByUserId(Auth::id())
            ->where(function ($query) {
                $query->whereDate('created_at', today());
            })
            ->take(2)
            ->get();
    }

    /**
     * Count Pending Appointments (role-based)
     */
    public function totalPendingAppointments()
    {
        return $this->appointmentQuery()
            ->where('status', 'Pending')
            ->distinct('patient_id')
            ->count('patient_id');
    }


    /**
     * Count Completed Appointments (role-based)
     */
    public function totalCompletedAppointments()
    {
        return $this->appointmentQuery()
            ->where('status', 'Completed')
            ->distinct('patient_id')
            ->count('patient_id');
    }


    /**
     * Count Cancelled Appointments (role-based)
     */
    public function totalCancelledAppointments()
    {
        return $this->appointmentQuery()
            ->where('status', 'Cancelled')
            ->distinct('patient_id')
            ->count('patient_id');
    }


    /**
     * Count Confirmed Appointments (role-based)
     */
    public function totalConfirmedAppointments()
    {
        return $this->appointmentQuery()
            ->where('status', 'Confirmed')
            ->distinct('patient_id')
            ->count('patient_id');
    }
}
