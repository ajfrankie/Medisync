<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEhrRecordRequest;
use App\Repositories\DoctorRepository;
use App\Repositories\EHRRepository;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


class EHRController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Get paginated EHR records with filters applied from the repository
    //     $ehrs = app(EHRRepository::class)->get($request)->paginate(10);

    //     // Load doctors and patients for dropdown filters
    //     $doctors = app(DoctorRepository::class)->get($request);
    //     $patients = app(PatientRepository::class)->get($request);

    //     // Pass everything to the view
    //     return view('backend.ehr.index', [
    //         'ehrs' => $ehrs,
    //         'doctors' => $doctors,
    //         'patients' => $patients,
    //         'request' => $request,
    //     ]);
    // }

    public function index(Request $request)
    {
        $authUser = Auth::user();

        $roleName = strtolower($authUser->role->role_name);

        $doctorRepo = app(DoctorRepository::class);
        $patientRepo = app(PatientRepository::class);
        $ehrRepo = app(EHRRepository::class);

        if ($roleName === 'doctor') {
            $doctor = $doctorRepo->findByUserId($authUser->id);
            $ehrs = $ehrRepo->get($request)
                ->where('doctor_id', $doctor->id)
                ->paginate(10);
        } elseif ($roleName === 'patient') {
            $patient = $patientRepo->findByUserId($authUser->id);
            $ehrs = $ehrRepo->get($request)
                ->where('patient_id', $patient->id)
                ->paginate(10);
        } else {
            $ehrs = $ehrRepo->get($request)->paginate(10);
        }

        $doctors = $doctorRepo->get($request)->get();
        $patients = $patientRepo->get($request)->get();

        return view('backend.ehr.index', [
            'ehrs' => $ehrs,
            'request' => $request,
            'doctors' => $doctors,
            'patients' => $patients,
        ]);
    }

    public function create(Request $request)
    {

        $doctors = app(DoctorRepository::class)->get($request)->get();
        $patients = app(PatientRepository::class)->get($request)->get();

        return view('backend.ehr.create', [
            'patients' => $patients,
            'doctors' => $doctors,
            'request' => $request,
        ]);
    }

    public function store(StoreEhrRecordRequest $request)
    {
        try {
            $ehr = app(EHRRepository::class)->create($request->all());
            return redirect()->route('admin.ehr.index')->with('success', 'EHR Record created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create EHR Record: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $ehr = app(EHRRepository::class)->find($id);
        return view('backend.ehr.edit', [
            'ehr' => $ehr,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $nurse = app(EHRRepository::class)->update($id, $request->all());
            return redirect()->route('admin.ehr.index')->with('success', 'EHR Record updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update EHR Record: ' . $e->getMessage());
        }
    }

    public function show($id, Request $request)
    {
        $ehr = app(EHRRepository::class)->find($id);


        return view('backend.ehr.show', [
            'ehr' => $ehr,
            'request' => $request,
        ]);
    }
}
