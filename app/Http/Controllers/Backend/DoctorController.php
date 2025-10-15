<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DoctorRepository;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
      $doctors = app(DoctorRepository::class)->get($request)->panigate(10);
        return view('backend.doctor.index',
      [
        'doctors' => $doctors,
        'request' => $request
      ]);
    }

    public function create(Request $request)
    {
        return view('backend.doctor.create');
    }

     public function store(Request $request)
    {
    }

      public function edit(Request $request)
    {
        return view('backend.doctor.edit');
    }

      public function update(Request $request)
    {
    }   
    
      public function destroy(Request $request)
    {
    }   

      public function deactivateCategory(Request $request)
    {
    }   

      public function activateCategory(Request $request)
    {
    }
}
