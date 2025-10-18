<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;

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

    public function create(Request $request)
    {
        return view('backend.patient.create');
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nic' => 'nullable|string|unique:users,nic',
            'phone' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('patients', 'public');
        }

        // Prepare input
        $input = $request->all();
        $input['image_path'] = $imagePath;

        // Create patient via repository
        $patient = app(PatientRepository::class)->create($input);

        return redirect()->route('admin.patient.index')->with('success', 'Patient created successfully.');
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

        return view('backend.patient.show', [
            'patient' => $patient,
            'request' => $request,
        ]);
    }
}
