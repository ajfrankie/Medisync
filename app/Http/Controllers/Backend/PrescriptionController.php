<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storePrescriptionRequest;
use App\Repositories\PrescriptionRepository;
use App\Repositories\VitalRepository;
use Illuminate\Support\Facades\Auth;


class PrescriptionController extends Controller
{


    public function index(Request $request)
    {
        // Get logged-in user's patient ID
        $patient = Auth::user()->patient ?? null;

        if (!$patient) {
            abort(403, 'You are not authorized to view prescriptions.');
        }

        // Get prescriptions for this patient
        $prescriptions = app(PrescriptionRepository::class)
            ->get($request)
            ->whereHas('vital.ehrRecord', function ($query) use ($patient) {
                $query->where('patient_id', $patient->id);
            })
            ->paginate(10);

        return view('backend.prescription.index', [
            'prescriptions' => $prescriptions,
            'request' => $request,
        ]);
    }

    public function create()
    {
        $vital = app(VitalRepository::class)->find(request()->get('vital_id'));

        if (!$vital) {
            return redirect()->back()->with('error', 'Vital not found.');
        }

        return view('backend.prescription.create', [
            'vital' => $vital,
        ]);
    }

    public function store(storePrescriptionRequest $request)
    {
        try {
            $prescription = app(PrescriptionRepository::class)->create($request->validated());


            return redirect()
                ->route('admin.ehr.index')
                ->with('success', 'prescription record created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create prescription record: ' . $e->getMessage());
        }
    }


    public function show($vitalId)
    {
        $prescriptionsByDate = app(PrescriptionRepository::class)
            ->findByVitalId($vitalId);

        if ($prescriptionsByDate->isEmpty()) {
            abort(404, 'No prescriptions found for this vital.');
        }

        return view('backend.prescription.show', compact('prescriptionsByDate'));
    }


    public function showPrescription($id)
    {
        $prescriptionsByDate = app(PrescriptionRepository::class)->find($id);

        if (!$prescriptionsByDate) {
            abort(404, 'No prescription found.');
        }

        return view(
            'backend.prescription.show',
            [
                'prescriptionsByDate' => $prescriptionsByDate,
            ]
        );
    }


    public function edit($id)
    {
        return view('backend.prescription.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Logic to update prescription data
    }
}
