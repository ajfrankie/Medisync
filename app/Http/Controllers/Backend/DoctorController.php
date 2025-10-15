<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DoctorRepository;

class DoctorController extends Controller
{
  protected $doctorRepository;

  public function __construct(DoctorRepository $doctorRepository)
  {
    $this->doctorRepository = $doctorRepository;
  }

  public function index(Request $request)
  {
    $doctors = $this->doctorRepository->get($request)->paginate(10);
    return view('backend.doctor.index', compact('doctors', 'request'));
  }


  public function create(Request $request)
  {
    return view('backend.doctor.create');
  }

  public function store(Request $request) {}

  public function edit(Request $request)
  {
    return view('backend.doctor.edit');
  }

  public function update(Request $request) {}

  public function destroy(Request $request) {}

  public function deactivateCategory(Request $request) {}

  public function activateCategory(Request $request) {}
}
