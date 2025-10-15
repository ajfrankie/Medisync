<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorRepository
{
    protected $model;

    public function __construct(Doctor $doctor)
    {
        $this->model = $doctor;
    }

    public function get(Request $request)
    {
        $query = Doctor::query();

        if (!empty($request->name)) {
            $query->where('name', 'LIKE', "%{$request->name}%");
        }

        if (!empty($request->veg_nonveg)) {
            $query->where('veg_nonveg', $request->veg_nonveg);
        }

        if ($request->has('is_activated')) {
            $query->where('is_activated', (bool) $request->is_activated);
        }

        return $query;
    }

    public function create(array $input)
    {
        $input['is_activated'] = true;
        return Doctor::create($input);
    }

    public function find($id)
    {
        return Doctor::find($id);
    }

    public function update($id, array $input)
    {
        $doctor = $this->find($id);
        if ($doctor) {
            $doctor->update($input);
        }
        return $doctor;
    }

    public function delete($id)
    {
        $doctor = $this->find($id);
        if ($doctor) {
            $doctor->delete();
        }
    }

    public function deactivate($id)
    {
        $doctor = $this->find($id);
        if ($doctor) {
            $doctor->is_activated = false;
            $doctor->save();
            return $doctor;
        }
        throw new \Exception('doctor not found');
    }

    public function activate($id)
    {
        $doctor = $this->find($id);
        if ($doctor) {
            $doctor->is_activated = true;
            $doctor->save();
            return $doctor;
        }
        throw new \Exception('doctor not found');
    }
}
