<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeDoctorRequest;
use App\Models\User;
use App\Repositories\DoctorRepository;
use App\Repositories\VitalRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class VitalController extends Controller
{
    protected $doctorRepository;


    public function index(Request $request)
    {
        $vitals = app(VitalRepository::class)->get($request)->paginate(10);
        // foreach ($vitals as $v) {
        //         dd($v->ehrRecord->doctor->user->name);
        //     }
        return view('backend.vital.index', [
            'vitals' => $vitals,
            'request' => $request,
        ]);
    }

    public function create() {}

    public function store(StoreDoctorRequest $request) {}



    public function edit(Request $request, $id) {}

    public function update(Request $request, $id) {}

    public function destroy(string $id) {}

    public function show($id, Request $request) {}
}
