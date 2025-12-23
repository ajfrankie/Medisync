<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
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
        $sugerDetails = $this->sugarDetails();
        $bloodPressure = $this->bloodPressure();
        $bmiDetails = $this->BMIcalculate($request);
        $pulseRate = $this->pulseRate();
        return view('backend.dashboard.patient_dashboard', [
            "AppointmentDate" => $AppointmentDate,
            "completedAppointments" => $completedAppointments,
            "nextAppointmentDate" => $nextAppointmentDate,
            "cancleAppointment" => $cancleAppointment,
            "yearAppointmetDetails" => $yearAppointmetDetails,
            "sugarDetails" => $sugerDetails,
            "bloodPressure" => $bloodPressure,
            "bmiDetails" => $bmiDetails,
            "pulseRate" => $pulseRate,
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

    public function sugarDetails()
    {
        $user = Auth::user();
        $patient = $user->patient;

        $vital = $patient->ehrRecords()
            ->with('vitals')
            ->latest()
            ->first()
            ?->vitals()
            ->latest()
            ->first();

        $bloodSugar = $vital?->blood_sugar; // mg/dL

        // Defaults
        $status = 'No Data';
        $color = 'secondary';
        $percentage = 0;

        if ($bloodSugar !== null) {
            if ($bloodSugar < 70) {
                $status = 'Low';
                $color = 'danger';
                $percentage = 25;
            } elseif ($bloodSugar <= 140) {
                $status = 'Good';
                $color = 'success';
                $percentage = 60;
            } else {
                $status = 'High';
                $color = 'warning';
                $percentage = 90;
            }
        }

        return [
            'value' => $bloodSugar,
            'status' => $status,
            'color' => $color,
            'percentage' => $percentage,
        ];
    }

    public function bloodPressure()
    {
        $user = Auth::user();
        $patient = $user->patient;

        // Get latest vital record
        $vital = $patient->ehrRecords()
            ->with('vitals')
            ->latest()
            ->first()
            ?->vitals()
            ->latest()
            ->first();

        $bloodPressure = $vital?->blood_pressure; // assuming stored as "systolic/diastolic" like "120/80"

        // Defaults
        $status = 'No Data';
        $color = 'secondary';
        $percentage = 0;

        if ($bloodPressure) {
            // Split into systolic & diastolic
            [$systolic, $diastolic] = explode('/', $bloodPressure);

            $systolic = (int) $systolic;
            $diastolic = (int) $diastolic;

            // Simple categorization based on standard ranges
            // Normal: 90-120 / 60-80
            // High: >= 130 / >= 80
            // Low: < 90 / < 60
            if ($systolic < 90 || $diastolic < 60) {
                $status = 'Low';
                $color = 'danger';
                $percentage = 30;
            } elseif ($systolic <= 120 && $diastolic <= 80) {
                $status = 'Normal';
                $color = 'success';
                $percentage = 70;
            } else {
                $status = 'High';
                $color = 'warning';
                $percentage = 90;
            }
        }

        return [
            'value' => $bloodPressure,
            'status' => $status,
            'color' => $color,
            'percentage' => $percentage,
        ];
    }

    public function pulseRate()
    {
        $user = Auth::user();
        $patient = $user->patient;

        // Get latest vital record
        $vital = $patient->ehrRecords()
            ->with('vitals')
            ->latest()
            ->first()
            ?->vitals()
            ->latest()
            ->first();

        $pulse = $vital?->pulse_rate; // assuming numeric value (bpm)

        // Defaults
        $status = 'No Data';
        $color = 'secondary';
        $percentage = 0;

        if ($pulse !== null) {
            // Categorize based on normal resting heart rate
            // Normal: 60-100 bpm
            // Low: <60 bpm
            // High: >100 bpm
            if ($pulse < 60) {
                $status = 'Low';
                $color = 'danger';
                $percentage = 30;
            } elseif ($pulse <= 100) {
                $status = 'Normal';
                $color = 'success';
                $percentage = 70;
            } else {
                $status = 'High';
                $color = 'warning';
                $percentage = 90;
            }
        }

        return [
            'value' => $pulse,
            'status' => $status,
            'color' => $color,
            'percentage' => $percentage,
        ];
    }

    public function BMIcalculate()
    {
        $patient = Auth::user()->patient;

        if (!$patient || !$patient->height || !$patient->weight) {
            return [
                'bmi' => null,
                'category' => 'Insufficient data',
            ];
        }

        $bmi = round($patient->weight / pow($patient->height / 100, 2), 2);

        $category = match (true) {
            $bmi < 18.5 => 'Underweight',
            $bmi < 25 => 'Normal weight',
            $bmi < 30 => 'Overweight',
            default => 'Obese',
        };

        return [
            'bmi' => $bmi,
            'category' => $category,
        ];
    }
}
