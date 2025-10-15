<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class DoctorRepository
{
    protected $model;

    public function __construct(Doctor $doctor)
    {
        $this->model = $doctor;
    }

    public function get(Request $request)
    {
        $query = Doctor::query()
            ->orderBy('created_at', 'desc');

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

    // public function create(array $input)
    // {
    //     $input['is_activated'] = true;
    //     return Doctor::create($input);
    // }


    public function create(array $input): Doctor
    {
        // Get the Doctor role
        $doctorRole = Role::where('role_name', 'Doctor')->firstOrFail();

        // Create the user
        $user = User::create([
            'role_id' => $doctorRole->id,
            'name'    => $input['name'],
            'email'   => $input['email'],
            'password' => Hash::make($input['password']),
            'phone'   => $input['phone'] ?? null,
        ]);

        // Create the doctor record linked to user
        $doctor = Doctor::create([
            'id'             => Str::uuid(),
            'user_id'        => $user->id,
            'specialization' => $input['specialization'],
            'department'     => $input['department'],
            'experience'     => $input['experience'] ?? null,
            'is_activated'   => true,
        ]);

        return $doctor;
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
