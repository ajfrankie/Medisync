<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorDashboardController extends Controller

{
    public function index()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Load the related doctor info
        $doctor = $user->doctor;

        // Optional: calculate dashboard stats
        // Assuming you have an 'appointments' relationship in Doctor model
        $totalAppointments = $doctor->appointments()->count();
        $completedAppointments = $doctor->appointments()->where('status', 'Completed')->count();
        $pendingAppointments = $doctor->appointments()->where('status', 'Pending')->count();

        $completedAppointmentsByMonth = $this->completedAppointmentsByMonth();
        $pendingAppointmentsByMonth = $this->pendingAppointmentsByMonth();
        $cancledAppointmentsByMonth = $this->cancledAppointmentsByMonth();
        $confirmedAppointmentsByMonth = $this->confirmedAppointmentsByMonth();
        $notifications = $this->notifications();
        $yearAppointmetDetails = $this->yearAppointmetDetails();

        $countMalePatients = $this->malePatientsCount();
        $countFemalePatients = $this->femalePatientsCount();
        $countUnder18Patients = $this->under18PatientsCount();
        $countAdultPatients = $this->adultPatientsCount();

        $bmiStats = $this->bmiSummary();

        // Pass all data to the view
        return view('backend.dashboard.doctor_dashboard', [
            'user' => $user,
            'doctor' => $doctor,
            'notifications' => $notifications,
            'totalAppointments' => $totalAppointments,
            'completedAppointments' => $completedAppointments,
            'pendingAppointments' => $pendingAppointments,
            'pendingAppointmentsByMonth' => $pendingAppointmentsByMonth,
            'completedAppointmentsByMonth' => $completedAppointmentsByMonth,
            'cancledAppointmentsByMonth' => $cancledAppointmentsByMonth,
            'confirmedAppointmentsByMonth' => $confirmedAppointmentsByMonth,
            'yearAppointmetDetails' => $yearAppointmetDetails,
            'countMalePatients' => $countMalePatients,
            'countFemalePatients' => $countFemalePatients,
            'countUnder18Patients' => $countUnder18Patients,
            'countAdultPatients' => $countAdultPatients,
            'bmiStats' => $bmiStats,
        ]);
    }


    public function pendingAppointmentsByMonth()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        // Get only the count of Pending appointments for the current month
        $pendingCount = $doctor->appointments()
            ->where('status', 'Pending')
            ->whereMonth('appointment_date', now()->month)
            ->whereYear('appointment_date', now()->year)
            ->count();

        return $pendingCount;
    }


    public function completedAppointmentsByMonth()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        // Get only the count of Pending appointments for the current month
        $completedAppointmentsByMonth = $doctor->appointments()
            ->where('status', 'Completed')
            ->whereMonth('appointment_date', now()->month)
            ->whereYear('appointment_date', now()->year)
            ->count();

        return $completedAppointmentsByMonth;
    }

    public function cancledAppointmentsByMonth()
    {

        $user = Auth::user();
        $doctor = $user->doctor;

        // Get only the count of Pending appointments for the current month
        $cancledAppointmentsByMonth = $doctor->appointments()
            ->where('status', 'Cancled')
            ->whereMonth('appointment_date', now()->month)
            ->whereYear('appointment_date', now()->year)
            ->count();

        return $cancledAppointmentsByMonth;
    }

    public function confirmedAppointmentsByMonth()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        // Get only the count of Pending appointments for the current month
        $confirmedAppointmentsByMonth = $doctor->appointments()
            ->where('status', 'Confirmed')
            ->whereMonth('appointment_date', now()->month)
            ->whereYear('appointment_date', now()->year)
            ->count();

        return $confirmedAppointmentsByMonth;
    }

    public function notifications()
    {
        $notifications = app(NotificationRepository::class)
            ->getByUserId(Auth::id())
            ->where(function ($query) {
                $query->whereDate('created_at', today());
            })
            ->take(2)
            ->get();

        return $notifications;
    }

    public function yearAppointmetDetails()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        $yearAppointmetDetails = $doctor->appointments()
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

    public function malePatientsCount()
    {
        $doctor = Auth::user()->doctor;

        return $doctor->appointments()
            ->whereHas('patient.user', function ($query) {
                $query->where('gender', 'Male');
            })
            ->distinct('patient_id')
            ->count('patient_id');
    }



    public function femalePatientsCount()
    {
        $doctor = Auth::user()->doctor;

        return $doctor->appointments()
            ->whereHas('patient.user', function ($query) {
                $query->where('gender', 'Female');
            })
            ->distinct('patient_id')
            ->count('patient_id');
    }



    public function under18PatientsCount()
    {
        $doctor = Auth::user()->doctor;

        return $doctor->appointments()
            ->whereHas('patient.user', function ($query) {
                $query->whereDate('dob', '>', now()->subYears(18));
            })
            ->distinct('patient_id')
            ->count('patient_id');
    }


    public function adultPatientsCount()
    {
        $doctor = Auth::user()->doctor;

        return $doctor->appointments()
            ->whereHas('patient.user', function ($query) {
                $query->whereDate('dob', '<=', now()->subYears(18));
            })
            ->distinct('patient_id')
            ->count('patient_id');
    }

    public function bmiSummary()
    {
        $doctor = Auth::user()->doctor;

        $patients = $doctor->appointments()
            ->with('patient')
            ->get()
            ->pluck('patient')
            ->unique('id');

        $underweight = 0;
        $normal = 0;
        $overweight = 0;
        $obese = 0;

        foreach ($patients as $patient) {

            if (!$patient || !$patient->height || !$patient->weight) {
                continue;
            }

            $heightM = $patient->height / 100;
            $bmi = $patient->weight / ($heightM * $heightM);

            if ($bmi < 18.5) {
                $underweight++;
            } elseif ($bmi < 25) {
                $normal++;
            } elseif ($bmi < 30) {
                $overweight++;
            } else {
                $obese++;
            }
        }

        $total = $underweight + $normal + $overweight + $obese;

        return [
            'underweight' => $underweight,
            'normal' => $normal,
            'overweight' => $overweight,
            'obese' => $obese,
            'total' => $total,
        ];
    }
}
