<?php


namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use App\Repositories\AppointmentRepository;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
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

        $genderSummary = $this->genderSummary();
        $ageData = $this->patientAgeDistribution();
        $bloodGroupData = $this->bloodGroupChartData();
        $heightData = $this->heightChartData();
        $weightData = $this->weightChartData();

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
            "genderSummary" => $genderSummary,
            "ageData" => $ageData,
            "bloodGroupData" => $bloodGroupData,
            "heightData" => $heightData,
            "weightData" => $weightData,
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


    public function genderSummary()
    {
        $maleCount = User::where('role_id', 2)
            ->where('gender', 'male')
            ->count();

        $femaleCount = User::where('role_id', 2)
            ->where('gender', 'female')
            ->count();

        return [
            'male' => $maleCount,
            'female' => $femaleCount,
        ];
    }

    public function patientAgeDistribution()
    {
        $patients = User::where('role_id', 2)
            ->whereNotNull('dob')
            ->get();

        // Group patients by birth year
        $grouped = $patients->groupBy(function ($patient) {
            return Carbon::parse($patient->dob)->year;
        })->sortKeys(); // <-- Sort keys ascending

        $birthYears = [];
        $avgAges = [];
        $counts = [];

        foreach ($grouped as $year => $patientsInYear) {
            $birthYears[] = $year;

            $averageAge = round($patientsInYear->avg(function ($p) {
                return Carbon::now()->year - Carbon::parse($p->dob)->year;
            }), 1);

            $avgAges[] = $averageAge;
            $counts[] = $patientsInYear->count();
        }

        return [
            'birthYears' => $birthYears,
            'avgAges' => $avgAges,
            'counts' => $counts
        ];
    }

    protected function bloodGroupChartData()
    {
        $patients = Patient::whereNotNull('blood_group')->get();

        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $bloodCounts = [];

        foreach ($bloodGroups as $bg) {
            $bloodCounts[] = $patients->where('blood_group', $bg)->count();
        }

        return [
            'bloodGroups' => $bloodGroups,
            'bloodCounts' => $bloodCounts
        ];
    }

    protected function heightChartData()
    {
        $patients = Patient::whereNotNull('height')->pluck('height')->toArray();

        // Define ranges (in cm)
        $ranges = [
            '140-149' => 0,
            '150-159' => 0,
            '160-169' => 0,
            '170-179' => 0,
            '180-189' => 0,
            '190-199' => 0,
        ];

        // Count patients per range
        foreach ($patients as $height) {
            if ($height >= 140 && $height <= 149) $ranges['140-149']++;
            elseif ($height >= 150 && $height <= 159) $ranges['150-159']++;
            elseif ($height >= 160 && $height <= 169) $ranges['160-169']++;
            elseif ($height >= 170 && $height <= 179) $ranges['170-179']++;
            elseif ($height >= 180 && $height <= 189) $ranges['180-189']++;
            elseif ($height >= 190 && $height <= 199) $ranges['190-199']++;
        }

        return [
            'rangeLabels' => array_keys($ranges),
            'counts' => array_values($ranges),
        ];
    }
    protected function weightChartData()
    {
        $patients = Patient::whereNotNull('weight')->pluck('weight')->toArray();

        // Define weight ranges (kg)
        $ranges = [
            '40-49' => 0,
            '50-59' => 0,
            '60-69' => 0,
            '70-79' => 0,
            '80-89' => 0,
            '90-99' => 0,
            '100+'  => 0,
        ];

        // Count patients per range
        foreach ($patients as $weight) {
            if ($weight >= 40 && $weight <= 49) $ranges['40-49']++;
            elseif ($weight >= 50 && $weight <= 59) $ranges['50-59']++;
            elseif ($weight >= 60 && $weight <= 69) $ranges['60-69']++;
            elseif ($weight >= 70 && $weight <= 79) $ranges['70-79']++;
            elseif ($weight >= 80 && $weight <= 89) $ranges['80-89']++;
            elseif ($weight >= 90 && $weight <= 99) $ranges['90-99']++;
            elseif ($weight >= 100) $ranges['100+']++;
        }

        return [
            'rangeLabels' => array_keys($ranges),
            'counts' => array_values($ranges),
        ];
    }
}
