<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatientRepository
{
    protected $model;

    public function __construct(Patient $patient)
    {
        $this->model = $patient;
    }

    public function get(Request $request)
    {
        $query = Patient::with('user')
            ->orderBy('created_at', 'desc');

        if (!empty($request->name)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->name}%");
            });
        }

        if (!empty($request->phone)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('phone', 'LIKE', "%{$request->phone}%");
            });
        }

       


        return $query;
    }

    public function create(array $input): Patient
    {
        // Fetch the "patient" role safely
        $patientRole = Role::where('role_name', 'Patient')->firstOrFail();

        $user = User::create([
            'id'       => Str::uuid(),
            'role_id'  => $patientRole->id,
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => Hash::make($input['password']),
            'phone'    => $input['phone'] ?? null,
        ]);

        return Patient::create([
            'id'           => Str::uuid(),
            'user_id'      => $user->id,
            'dob'   => $input['dob'] ?? 'general',
            'gender'   => $input['gender'] ?? null,
            'blood_group'   => $input['blood_group'] ?? null,
            'address'   => $input['address'] ?? null,
            'emergency_person'   => $input['emergency_person'] ?? null,
            'emergency_relationship'   => $input['emergency_relationship'] ?? null,
            'emergency_contact'   => $input['emergency_contact'] ?? null,
            'image_path'   => $input['image_path'] ?? null,
        ]);
    }

    public function find($id)
    {
        return Patient::with('user')->find($id);
    }

    public function update($id, array $input)
    {
        $patient = $this->find($id);
        if (!$patient) {
            throw new ModelNotFoundException('patient not found');
        }


        $user = $patient->user;
        if ($user) {
            $user->name = $input['name'] ?? $user->name;
            $user->email = $input['email'] ?? $user->email;
            $user->phone = $input['phone'] ?? $user->phone;

            if (!empty($input['password'])) {
                $user->password = Hash::make($input['password']);
            }

            $user->save();
        }

        return $patient;
    }

    public function delete($id)
    {
        $patient = $this->find($id);
        if ($patient) {
            $patient->delete();
        }
    }

    public function deactivate($id)
    {
        $patient = $this->find($id);
        if ($patient) {
            $patient->is_activated = false;
            $patient->save();
            return $patient;
        }

        throw new \Exception('patient not found');
    }

    public function activate($id)
    {
        $patient = $this->find($id);
        if ($patient) {
            $patient->is_activated = true;
            $patient->save();
            return $patient;
        }

        throw new \Exception('patient not found');
    }
}
