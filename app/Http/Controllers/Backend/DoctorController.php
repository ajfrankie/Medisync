<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeDoctorRequest;
use App\Models\Doctor;
use App\Models\User;
use App\Repositories\DoctorRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
  protected $doctorRepository;


  public function index(Request $request)
  {
    $doctors = app(DoctorRepository::class)->get($request)->paginate(10);
    return view('backend.doctor.index', [
      'doctors' => $doctors,
      'request' => $request,
    ]);
  }

  public function create()
  {
    $authUser = Auth::user();

    // Allow only Admin Officer
    if (!in_array($authUser->role->role_name, ['Admin Officer'])) {
      abort(403, 'Access denied. Only Admin Officer can create Doctor accounts.');
    }

    // Get users with Doctor role who are NOT in doctors table
    $doctorUsers = User::where('role_id', 1)
      ->get();

    return view('backend.doctor.create', [
      'doctorUsers' => $doctorUsers,
    ]);
  }

  public function store(StoreDoctorRequest $request)
  {
    try {
      // Attempt to create doctor record
      $doctor = app(DoctorRepository::class)->create($request->validated());

      return redirect()
        ->route('admin.doctor.index')
        ->with('success', 'Doctor created successfully.');
    } catch (\Illuminate\Database\QueryException $e) {
      // Check if duplicate user_id constraint was violated (SQLSTATE 23000)
      if ($e->getCode() == 23000) {
        return back()
          ->withInput()
          ->with('error', 'This user already has a doctor profile. Please select a different user.');
      }

      // Handle any other database-related error
      return back()
        ->withInput()
        ->with('error', 'A database error occurred while creating the doctor: ' . $e->getMessage());
    } catch (\Exception $e) {
      // Handle any other unexpected errors
      return back()
        ->withInput()
        ->with('error', 'Failed to create doctor: ' . $e->getMessage());
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
      $doctor = app(DoctorRepository::class)->update($id, $request->all());
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

  public function show($id, Request $request)
  {
    try {
      $doctor = app(DoctorRepository::class)->find($id);

      if (!$doctor) {
        return redirect()
          ->route('admin.doctor.index')
          ->with('error', 'Doctor order not found.');
      }

      return view('backend.doctor.show', [
        'doctor' => $doctor,
        'request' => $request,
      ]);
    } catch (\Exception $e) {
      return back()
        ->with('error', 'Failed to fetch doctor order details: ' . $e->getMessage());
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

  //patient profile section 
  public function showDoctor($id)
  {
    $doctor = app(DoctorRepository::class)->find($id);

    // dd($patient->user->id);
    return view('backend.doctor.profile', [
      'doctor' => $doctor,
    ]);
  }

  public function editDoctor(Request $request, $id)
  {
    $doctor = app(DoctorRepository::class)->find($id);

    return view('backend.doctor.editprofile', [
      'doctor' => $doctor,
    ]);
  }


  public function updateDoctor(Request $request, $id)
  {
    // Find the patient
    $doctor = Doctor::with('user')->findOrFail($id);
    $user = $doctor->user;

    // Handle user fields
    if ($user) {
      $user->name = $request->input('name', $user->name);
      $user->email = $request->input('email', $user->email);
      $user->dob = $request->input('dob', $user->dob);
      $user->nic = $request->input('nic', $user->nic);
      $user->gender = $request->input('gender', $user->gender);
      $user->phone = $request->input('phone', $user->phone);

      // Password update
      if ($request->filled('password')) {
        if ($request->input('password') === $request->input('password_confirmation')) {
          $user->password = bcrypt($request->input('password'));
        } else {
          return redirect()->back()->with('error', 'Password confirmation does not match.')->withInput();
        }
      }

      // File upload
      if ($request->hasFile('image_path')) {
        $file = $request->file('image_path');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/profile_images', $filename);
        $user->image_path = 'profile_images/' . $filename;
      }

      $user->save();
    }

    // Handle Doctor fields
    $doctor->specialization = $request->input('specialization', $doctor->specialization);
    $doctor->department = $request->input('department', $doctor->department);
    $doctor->experience = $request->input('experience', $doctor->experience);
    

    $doctor->save();

    return redirect()->route('admin.doctor.showDoctor', $doctor->id)
      ->with('success', 'Doctor profile updated successfully.');
  }
}
