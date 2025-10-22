<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEhrRecordRequest;
use App\Repositories\DoctorRepository;
use App\Repositories\EHRRepository;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\App;

class EHRController extends Controller
{
    public function index(Request $request)
    {
        $ehrs = app(EHRRepository::class)->get(request())->paginate(10);

        return view('backend.ehr.index', [
            'ehrs' => $ehrs,
            'request' => $request,
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


    public function edit() {}

    public function update() {}

    public function show() {}
}
