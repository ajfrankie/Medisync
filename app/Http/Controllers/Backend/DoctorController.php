<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeDoctorRequest;
use App\Repositories\DoctorRepository;

class DoctorController extends Controller
{
  protected $doctorRepository;


  public function index(Request $request)
  {
    $doctors = app(DoctorRepository::class)->get($request)->paginate(10);
    return view('backend.doctor.index', compact('doctors', 'request'));
  }


  public function create(Request $request)
  {
    return view('backend.doctor.create');
  }

  public function store(storeDoctorRequest $request)
  {
    try {
      $doctor = app(DoctorRepository::class)->create($request->all());
      return redirect()->route('admin.doctor.index')->with('success', 'Doctor created successfully.');
    } catch (\Exception $e) {
      return back()->withInput()->with('error', 'Failed to create Doctor: ' . $e->getMessage());
    }
  }


  public function edit(Request $request)
  {
    return view('backend.doctor.edit');
  }

  public function update(Request $request) {}

  public function destroy(Request $request) {}

  public function deactivateCategory(Request $request) {}

  public function activateCategory(Request $request) {}
}
