<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeDoctorRequest;
use App\Repositories\DoctorRepository;
use Illuminate\Support\Facades\App;

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


  public function edit(Request $request, $id)
  {
    $doctor = app(DoctorRepository::class)->find($id);
    return view('backend.doctor.edit', [
      'doctor' => $doctor,
    ]);
  }

  public function update(Request $request, $id)
  {
    try {
      $city = app(DoctorRepository::class)->update($id, $request->all());
      return redirect()->route('admin.doctor.index')->with('success', 'Doctor updated successfully.');
    } catch (\Exception $e) {
      return back()->withInput()->with('error', 'Failed to update Doctor: ' . $e->getMessage());
    }
  }

  public function destroy(string $id)
  {
    try {
      $doctor = app(DoctorRepository::class)->delete($id);
      return redirect()->route('admin.doctor.index')->with('success', 'Doctor deleted successfully.');
    } catch (\Exception $e) {
      return back()->withInput()->with('error', 'Failed to delete doctor: ' . $e->getMessage());
    }
  }

  public function deactivateDoctor($id)
  {
    try {
      $doctor = app(DoctorRepository::class)->find($id);

      if (!$doctor) {
        return redirect()->back()->with('error', 'Doctor not found.');
      }

      app(DoctorRepository::class)->deactivate($id);

      return redirect()->route('admin.doctor.index')
        ->with('success', 'Doctor deactivated successfully.');
    } catch (\Exception $e) {
      $this->logError('deactivateDoctor', $e, $id);
      return back()->withInput()->with('error', 'Failed to deactivate Doctor: ' . $e->getMessage());
    }
  }

  public function activateDoctor($id)
  {
    try {
      $doctor = app(DoctorRepository::class)->find($id);

      if (!$doctor) {
        return redirect()->back()->with('error', 'Doctor not found.');
      }

      app(DoctorRepository::class)->activate($id); // ✅ correct method now

      return redirect()->route('admin.doctor.index')
        ->with('success', 'Doctor activated successfully.');
    } catch (\Exception $e) {
      $this->logError('activateDoctor', $e, $id);
      return back()->withInput()->with('error', 'Failed to activate Doctor: ' . $e->getMessage());
    }
  }
}
