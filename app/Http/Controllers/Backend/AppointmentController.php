<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeAppointmentRequest;
use App\Models\Doctor;
use App\Repositories\AppointmentRepository;
use App\Repositories\DoctorRepository;
use App\Repositories\PatientRepository;

class AppointmentController extends Controller
{

    protected $doctorRepository;


    public function index(Request $request)
    {
        $appointments = app(AppointmentRepository::class)->get($request)->paginate(10);
        return view('backend.appointment.index', [
            'appointments' => $appointments,
            'request' => $request,
        ]);
    }


    public function create(Request $request)
    {

        $doctors = app(DoctorRepository::class)->get($request)->get();
        $patients = app(PatientRepository::class)->get($request)->get();

        $appointments = app(AppointmentRepository::class)->get($request)->paginate(10);
        return view('backend.appointment.create', [
            'appointments' => $appointments,
            'request' => $request,
            'doctors' => $doctors,
            'patients' => $patients,
        ]);
    }

    public function store(storeAppointmentRequest $request)
    {
        try {
            $appointment =  app(AppointmentRepository::class)->create($request->validated());

            return redirect()
                ->route('admin.appointment.index')
                ->with('success', 'Appointment created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create Appointment: ' . $e->getMessage());
        }
    }


    public function edit(Request $request, $id) {}

    public function update(Request $request, $id) {}


    public function show($id, Request $request) {}

    public function getDoctorDetails(Request $request)
    {
        $doctor = \App\Models\Doctor::find($request->doctor_id);

        if ($doctor) {
            return response()->json([
                'success' => true,
                'department' => $doctor->department ?? 'N/A',
                'specialization' => $doctor->specialization ?? 'N/A',
            ]);
        }

        return response()->json(['success' => false]);
    }
}
