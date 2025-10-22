<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DoctorRepository;
use App\Repositories\EHRRepository;
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

    public function create() {}

    public function store() {}

    public function edit() {}

    public function update() {}

    public function show() {}
}
