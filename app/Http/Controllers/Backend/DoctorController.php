<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.doctor.index');
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
