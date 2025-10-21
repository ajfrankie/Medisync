<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AppointmentRepository;

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


    public function create(Request $request) {}

    public function store(Request $request) {}


    public function edit(Request $request, $id) {}

    public function update(Request $request, $id) {}


    public function show($id, Request $request) {}

    public function deactivateAppointment($id) {}

    public function activateAppointment($id) {}
}
