<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
        $query = Patient::with('user')->orderBy('created_at', 'desc');

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

        if (!empty($request->nic)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nic', 'LIKE', "%{$request->nic}%");
            });
        }

         if (!empty($request->gender)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('gender', 'LIKE', "%{$request->gender}%");
            });
        }

        if (!empty($request->blood_group)) {
            $query->where('blood_group', 'LIKE', "%{$request->blood_group}%");
        }

        if (!empty($request->dob)) {
            $query->where('dob', 'LIKE', "%{$request->dob}%");
        }

     

        if (!empty($request->emergency_contact)) {
            $query->where('emergency_contact', 'LIKE', "%{$request->emergency_contact}%");
        }

        if ($request->has('is_activated')) {
            $query->where('is_activated', (bool) $request->is_activated);
        }


        return $query;
    }

    public function create(array $input): Patient
    {
        $patientRole = Role::where('role_name', 'Patient')->firstOrFail();

        $user = User::create([
            'id'         => Str::uuid(),
            'role_id'    => $patientRole->id,
            'name'       => $input['name'],
            'email'      => $input['email'],
            'nic'        => $input['nic'] ?? null,
            'dob'        => $input['dob'] ?? null,
            'gender'     => $input['gender'] ?? null,
            'image_path' => $input['image_path'] ?? null,
            'password'   => Hash::make($input['password']),
            'phone'      => $input['phone'] ?? null,
        ]);

        return Patient::create([
            'id'                   => Str::uuid(),
            'user_id'              => $user->id,
            'dob'                  => $input['dob'] ?? null,
            'blood_group'          => $input['blood_group'] ?? null,
            'address'              => $input['address'] ?? null,
            'emergency_person'     => $input['emergency_person'] ?? null,
            'emergency_relationship' => $input['emergency_relationship'] ?? null,
            'emergency_contact'    => $input['emergency_contact'] ?? null,
        ]);
    }

    public function find($id)
    {
        return Patient::with('user')->find($id);
    }

    public function update($id, array $input)
    {
        $patient = $this->find($id);
        if (!$patient) throw new ModelNotFoundException('Patient not found');

        $user = $patient->user;
        if ($user) {
            $user->name = $input['name'] ?? $user->name;
            $user->phone = $input['phone'] ?? $user->phone;
            $user->nic = $input['nic'] ?? $user->nic;
            $user->gender = $input['gender'] ?? $user->nic;

            if (!empty($input['password'])) {
                $user->password = Hash::make($input['password']);
            }

            // Handle image
            if (!empty($input['image_path'])) {
                if ($input['image_path'] instanceof \Illuminate\Http\UploadedFile) {
                    $user->image_path = $input['image_path']->store('patients', 'public');
                } else {
                    $user->image_path = $input['image_path'];
                }
            }

            $user->save();
        }

        $patient->dob = $input['dob'] ?? $patient->dob;
        $patient->blood_group = $input['blood_group'] ?? $patient->blood_group;
        $patient->address = $input['address'] ?? $patient->address;
        $patient->emergency_person = $input['emergency_person'] ?? $patient->emergency_person;
        $patient->emergency_relationship = $input['emergency_relationship'] ?? $patient->emergency_relationship;
        $patient->emergency_contact = $input['emergency_contact'] ?? $patient->emergency_contact;

        $patient->save();

        return $patient;
    }

    public function delete($id)
    {
        $patient = $this->find($id);
        if ($patient) $patient->delete();
    }

    public function deactivate($id)
    {
        $patient = $this->find($id);
        if ($patient) {
            $patient->is_activated = false;
            $patient->save();
            return $patient;
        }
        throw new \Exception('Patient not found');
    }

    public function activate($id)
    {
        $patient = $this->find($id);
        if ($patient) {
            $patient->is_activated = true;
            $patient->save();
            return $patient;
        }
        throw new \Exception('Patient not found');
    }
}
