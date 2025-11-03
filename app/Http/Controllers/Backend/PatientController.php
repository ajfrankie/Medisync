<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use App\Models\User;
use App\Repositories\EHRRepository;
use App\Repositories\PatientRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    protected $patientRepository;

    public function index(Request $request)
    {
        $patients = app(PatientRepository::class)->get($request)->paginate(10);

        return view('backend.patient.index', [
            'patients' => $patients,
            'request' => $request,
        ]);
    }

    public function create()
    {
        $authUser = Auth::user();

        // Allow only Admin Officer
        if ($authUser->role->role_name !== 'Admin Officer') {
            abort(403, 'Access denied. Only Admin Officers can create Nurse accounts.');
        }

        // Get users with Nurse role (role_id = 3) who are NOT already in nurses table
        $patientUsers = User::where('role_id', 2)
            ->get();

        return view('backend.patient.create', [
            'patientUsers' => $patientUsers,
        ]);
    }


    public function store(StorePatientRequest $request)
    {
        try {
            // Create nurse record using validated data
            $nurse = app(PatientRepository::class)->create($request->validated());

            return redirect()
                ->route('admin.patient.index')
                ->with('success', 'Patient created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Duplicate user_id error (unique constraint)
            if ($e->getCode() == 23000) {
                return back()
                    ->withInput()
                    ->with('error', 'This user already has a patient profile. Please select a different user.');
            }

            return back()
                ->withInput()
                ->with('error', 'A database error occurred while creating the patient: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create patient: ' . $e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        $patient = app(PatientRepository::class)->find($id);

        return view('backend.patient.edit', [
            'patient' => $patient,
        ]);
    }

    public function update(Request $request, $id)
    {
        $patient = app(PatientRepository::class)->find($id);
        $userId = $patient->user->id ?? null;

        // Validate request, including NIC uniqueness correctly
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
            'nic' => 'nullable|string|unique:users,nic,' . $userId . ',id',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $input = $request->all();

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $input['image_path'] = $request->file('image_path')->store('patients', 'public');
        }

        // Update patient using repository
        $patient = app(PatientRepository::class)->update($id, $input);

        return redirect()->route('admin.patient.index')->with('success', 'Patient updated successfully.');
    }


    public function destroy(string $id)
    {
        app(PatientRepository::class)->delete($id);
        return redirect()->route('admin.patient.index')->with('success', 'Patient deleted successfully.');
    }

    public function show($id, Request $request)
    {
        $patient = app(PatientRepository::class)->find($id);

        if (!$patient) {
            return redirect()->route('admin.patient.index')->with('error', 'Patient not found.');
        }

        // Use repository method, not Eloquent relationship
        $ehrRecords = app(EHRRepository::class)->findByPatientID($id);

        $request->merge(['patient_id' => $id]);
        $age = $this->ageCalculate($request);
        $bmiData = $this->BMIcalculate($request);

        return view('backend.patient.show', [
            'patient' => $patient,
            'age' => $age,
            'bmiData' => $bmiData,
            'ehrRecords' => $ehrRecords, // collection
        ]);
    }


    public function ageCalculate(Request $request)
    {
        $patient = app(PatientRepository::class)->find($request->patient_id);

        if (!$patient || !$patient->user || empty($patient->user->dob)) {
            return null; // no DOB available
        }

        $birthDate = Carbon::parse($patient->user->dob);
        return $birthDate->diffInYears(Carbon::today());
    }

    public function BMIcalculate(Request $request)
    {
        $patient = app(PatientRepository::class)->find($request->patient_id);

        if (!$patient || empty($patient->height) || empty($patient->weight) || $patient->height == 0) {
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

    //patient profile section 
    public function showPatient($id)
    {
        $patient = app(PatientRepository::class)->find($id);

        // dd($patient->user->id);
        return view('backend.patient.profile', [
            'patient' => $patient,
        ]);
    }

    public function editPatient(Request $request, $id)
    {
        $patient = app(PatientRepository::class)->find($id);

        return view('backend.patient.editprofile', [
            'patient' => $patient,
        ]);
    }


    public function updatePatient(Request $request, $id)
    {
        // Find the patient
        $patient = Patient::with('user')->findOrFail($id);
        $user = $patient->user;

        // Handle user fields
        if ($user) {
            $user->name = $request->input('name', $user->name);
            $user->email = $request->input('email', $user->email);
            $user->dob = $request->input('dob', $user->dob);
            $user->nic = $request->input('nic', $user->nic);
            $user->gender = $request->input('gender', $user->gender);
            $user->phone = $request->input('phone', $user->phone);

            // Password update
            if ($request->filled('password')) {
                if ($request->input('password') === $request->input('password_confirmation')) {
                    $user->password = bcrypt($request->input('password'));
                } else {
                    return redirect()->back()->with('error', 'Password confirmation does not match.')->withInput();
                }
            }

            // File upload
            if ($request->hasFile('image_path')) {
                $file = $request->file('image_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/profile_images', $filename);
                $user->image_path = 'profile_images/' . $filename;
            }

            $user->save();
        }

        // Handle patient fields
        $patient->blood_group = $request->input('blood_group', $patient->blood_group);
        $patient->marital_status = $request->input('marital_status', $patient->marital_status);
        $patient->preferred_language = $request->input('preferred_language', $patient->preferred_language);
        $patient->occupation = $request->input('occupation', $patient->occupation);
        $patient->height = $request->input('height', $patient->height);
        $patient->weight = $request->input('weight', $patient->weight);
        $patient->past_surgeries = $request->input('past_surgeries', $patient->past_surgeries);
        $patient->past_surgeries_details = $request->input('past_surgeries_details', $patient->past_surgeries_details);
        $patient->emergency_person = $request->input('emergency_person', $patient->emergency_person);
        $patient->emergency_relationship = $request->input('emergency_relationship', $patient->emergency_relationship);
        $patient->emergency_contact = $request->input('emergency_contact', $patient->emergency_contact);

        $patient->save();

        return redirect()->route('admin.patient.showPatient', $patient->id)
            ->with('success', 'Patient profile updated successfully.');
    }
}
