<?php


namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
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

        $sugarSummary = $this->adminSugarSummary();
        $bloodPressureSummary = $this->adminBloodPressureSummary();
        $pulseRateSummary = $this->adminPulseRateSummary();
        $bmiSummary = $this->adminBMISummary();

        // $genderSummary = $this->genderSummary();

        return view('backend.dashboard.admin_dashboard', [
            "countDoctors" => $countDoctors,
            "countPatients" => $countPatients,
            "countNurses" => $countNurses,
            "countAdmins" => $countAdmins,
            "appointmentsPercentage" => $appointmentsPercentage,
            "cancelledAppoinmentPercentage" => $cancelledAppoinmentPercentage,
            "pendingAppoinmentPercentage" => $pendingAppoinmentPercentage,
            "sugarSummary" => $sugarSummary,
            "bloodPressureSummary" => $bloodPressureSummary,
            "pulseRateSummary" => $pulseRateSummary,
            "bmiSummary" => $bmiSummary,
            // "genderSummary" => $genderSummary,
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

    public function adminSugarSummary()
    {
        $patients = Patient::with([
            'ehrRecords.vitals' => function ($query) {
                $query->whereNotNull('blood_sugar')
                    ->latest();
            }
        ])->get();

        $low = 0;
        $good = 0;
        $high = 0;

        foreach ($patients as $patient) {

            // Get latest vital across all ehr records
            $latestVital = $patient->ehrRecords
                ->flatMap(fn($ehr) => $ehr->vitals)
                ->sortByDesc('created_at')
                ->first();

            if (!$latestVital) {
                continue;
            }

            $sugar = $latestVital->blood_sugar;

            if ($sugar < 70) {
                $low++;
            } elseif ($sugar <= 140) {
                $good++;
            } else {
                $high++;
            }
        }

        return [
            'low' => $low,
            'good' => $good,
            'high' => $high,
            'total' => $low + $good + $high,
        ];
    }

    //BloodPressure Summary
    public function adminBloodPressureSummary()
    {
        $patients = Patient::with([
            'ehrRecords.vitals' => function ($query) {
                $query->whereNotNull('blood_pressure')
                    ->latest();
            }
        ])->get();

        $low = 0;
        $normal = 0;
        $high = 0;

        foreach ($patients as $patient) {

            $latestVital = $patient->ehrRecords
                ->flatMap(fn($ehr) => $ehr->vitals)
                ->sortByDesc('created_at')
                ->first();

            if (!$latestVital || !$latestVital->blood_pressure) {
                continue;
            }

            // Expecting format: "120/80"
            [$systolic, $diastolic] = explode('/', $latestVital->blood_pressure);

            $systolic = (int) $systolic;
            $diastolic = (int) $diastolic;

            if ($systolic < 90 || $diastolic < 60) {
                $low++;
            } elseif ($systolic <= 120 && $diastolic <= 80) {
                $normal++;
            } else {
                $high++;
            }
        }

        return [
            'low' => $low,
            'normal' => $normal,
            'high' => $high,
            'total' => $low + $normal + $high,
        ];
    }

    //PulseRate Summary
    public function adminPulseRateSummary()
    {
        $patients = \App\Models\Patient::with([
            'ehrRecords.vitals' => function ($query) {
                $query->whereNotNull('pulse_rate')
                    ->latest();
            }
        ])->get();

        $low = 0;
        $normal = 0;
        $high = 0;

        foreach ($patients as $patient) {

            $latestVital = $patient->ehrRecords
                ->flatMap(fn($ehr) => $ehr->vitals)
                ->sortByDesc('created_at')
                ->first();

            if (!$latestVital || $latestVital->pulse_rate === null) {
                continue;
            }

            $pulse = (int) $latestVital->pulse_rate;

            if ($pulse < 60) {
                $low++;
            } elseif ($pulse <= 100) {
                $normal++;
            } else {
                $high++;
            }
        }

        return [
            'low' => $low,
            'normal' => $normal,
            'high' => $high,
            'total' => $low + $normal + $high,
        ];
    }

    public function adminBMISummary()
    {
        $patients = \App\Models\Patient::whereNotNull('height')
            ->whereNotNull('weight')
            ->get();

        $underweight = 0;
        $normal = 0;
        $overweight = 0;
        $obese = 0;

        foreach ($patients as $patient) {

            if ($patient->height == 0) {
                continue;
            }

            $bmi = $patient->weight / pow($patient->height / 100, 2);

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

        return [
            'underweight' => $underweight,
            'normal' => $normal,
            'overweight' => $overweight,
            'obese' => $obese,
            'total' => $underweight + $normal + $overweight + $obese,
        ];
    }


    // public function genderSummary()
    // {
    //     $maleCount = User::where('role_id', 2)
    //         ->where('gender', 'male')
    //         ->count();

    //     $femaleCount = User::where('role_id', 2)
    //         ->where('gender', 'female')
    //         ->count();

    //     return [
    //         'male' => $maleCount,
    //         'female' => $femaleCount,
    //     ];
    // }
}
