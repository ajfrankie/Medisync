<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;

class PatientController extends Controller
{
    protected $nurseRepository;


    public function index(Request $request)
    {
        $patients = app(PatientRepository::class)->get($request)->paginate(10);


        // foreach ($patients as $patient) {
        //     dd($patient->emergency_relationship);
        // }
        return view('backend.patient.index',  [
            'patients' => $patients,
            'request' => $request,
        ]);;
    }
}
