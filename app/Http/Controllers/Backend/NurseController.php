<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeNurseRequest;
use App\Models\User;
use App\Repositories\NurseRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class NurseController extends Controller
{
  protected $nurseRepository;


  public function index(Request $request)
  {
    $nurses = app(NurseRepository::class)->get($request)->paginate(10);
    return view('backend.nurse.index',  [
      'nurses' => $nurses,
      'request' => $request,
    ]);;
  }


  public function create()
  {
    $authUser = Auth::user();

    // Allow only Admin Officer
    if ($authUser->role->role_name !== 'Admin Officer') {
      abort(403, 'Access denied. Only Admin Officers can create Nurse accounts.');
    }

    // Get users with Nurse role (role_id = 3) who are NOT already in nurses table
    $nurseUsers = User::where('role_id', 3)
      ->get();

    return view('backend.nurse.create', [
      'nurseUsers' => $nurseUsers,
    ]);
  }


  public function store(StoreNurseRequest $request)
  {
    try {
      // Create nurse record using validated data
      $nurse = app(NurseRepository::class)->create($request->validated());

      return redirect()
        ->route('admin.nurse.index')
        ->with('success', 'Nurse created successfully.');
    } catch (\Illuminate\Database\QueryException $e) {
      // Duplicate user_id error (unique constraint)
      if ($e->getCode() == 23000) {
        return back()
          ->withInput()
          ->with('error', 'This user already has a nurse profile. Please select a different user.');
      }

      return back()
        ->withInput()
        ->with('error', 'A database error occurred while creating the nurse: ' . $e->getMessage());
    } catch (\Exception $e) {
      return back()
        ->withInput()
        ->with('error', 'Failed to create nurse: ' . $e->getMessage());
    }
  }


  public function edit(Request $request, $id)
  {
    $nurse = app(NurseRepository::class)->find($id);
    return view('backend.nurse.edit', [
      'nurse' => $nurse,
    ]);
  }

  public function update(Request $request, $id)
  {
    try {
      $nurse = app(NurseRepository::class)->update($id, $request->all());
      return redirect()->route('admin.nurse.index')->with('success', 'nurse updated successfully.');
    } catch (\Exception $e) {
      return back()->withInput()->with('error', 'Failed to update nurse: ' . $e->getMessage());
    }
  }

  public function destroy(string $id)
  {
    try {
      $nurse = app(NurseRepository::class)->delete($id);
      return redirect()->route('admin.nurse.index')->with('success', 'nurse deleted successfully.');
    } catch (\Exception $e) {
      return back()->withInput()->with('error', 'Failed to delete nurse: ' . $e->getMessage());
    }
  }

  public function show($id, Request $request)
  {
    try {
      $nurse = app(NurseRepository::class)->find($id);

      if (!$nurse) {
        return redirect()
          ->route('admin.nurse.index')
          ->with('error', 'nurse order not found.');
      }

      return view('backend.nurse.show', [
        'nurse' => $nurse,
        'request' => $request,
      ]);
    } catch (\Exception $e) {
      return back()
        ->with('error', 'Failed to fetch nurse order details: ' . $e->getMessage());
    }
  }

  public function deactivateNurse($id)
  {
    try {
      $nurse = app(NurseRepository::class)->find($id);

      if (!$nurse) {
        return redirect()->back()->with('error', 'Nurse not found.');
      }

      app(NurseRepository::class)->deactivate($id);

      return redirect()->route('admin.nurse.index')
        ->with('success', 'nurse deactivated successfully.');
    } catch (\Exception $e) {
      $this->logError('deactivatenurse', $e, $id);
      return back()->withInput()->with('error', 'Failed to deactivate nurse: ' . $e->getMessage());
    }
  }

  public function activateNurse($id)
  {
    try {
      $nurse = app(NurseRepository::class)->find($id);

      if (!$nurse) {
        return redirect()->back()->with('error', 'nurse not found.');
      }

      app(NurseRepository::class)->activate($id); // ✅ correct method now

      return redirect()->route('admin.nurse.index')
        ->with('success', 'nurse activated successfully.');
    } catch (\Exception $e) {
      $this->logError('activatenurse', $e, $id);
      return back()->withInput()->with('error', 'Failed to activate nurse: ' . $e->getMessage());
    }
  }
}
