<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrescriptionController extends Controller
{
   public function index()
   {
       return view('backend.prescription.index');
   }

    public function create()
    {
         return view('backend.prescription.create');
    }

    public function store(Request $request)
    {
        // Logic to store prescription data
    }

    public function show($id)
    {
        return view('backend.prescription.show', ['id' => $id]);
    }

    public function edit($id)
    {
        return view('backend.prescription.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Logic to update prescription data
    }

    
}
