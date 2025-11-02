<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storePrescriptionRequest;
use App\Repositories\PrescriptionRepository;
use App\Repositories\VitalRepository;

class PrescriptionController extends Controller
{

    public function index(Request $request)
    {
        $vitalId = $request->get('vital');

        $prescriptions = app(PrescriptionRepository::class)->get($request)->paginate(10);

        $vital = null;
        if ($vitalId) {
            $vital = app(VitalRepository::class)->find($vitalId);
            if (!$vital) {
                return redirect()->back()->with('error', 'Vital not found.');
            }
        }

        return view('backend.vital.index', [
            'prescriptions' => $prescriptions,
            'request' => $request,
            'vital' => $vital,
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


    public function show($id)
    {
        return view('backend.prescription.show', ['id' => $id]);
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
