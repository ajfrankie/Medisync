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
        // Ensure user_id is present
        if (empty($input['user_id'])) {
            throw new \InvalidArgumentException('User ID is required to create a Patient record.');
        }

        // Create Patient record
        return Patient::create([
            'user_id'                  => $input['user_id'],
            'blood_group'              => $input['blood_group'] ?? null,
            'marital_status'           => $input['marital_status'] ?? null,
            'occupation'               => $input['occupation'] ?? null,
            'height'                   => $input['height'] ?? null,
            'weight'                   => $input['weight'] ?? null,
            'past_surgeries'           => $input['past_surgeries'] ?? null,
            'past_surgeries_details'   => $input['past_surgeries_details'] ?? null,
            'emergency_person'         => $input['emergency_person'] ?? null,
            'preferred_language'       => $input['preferred_language'] ?? null,
            'emergency_relationship'   => $input['emergency_relationship'] ?? null,
            'emergency_contact'        => $input['emergency_contact'] ?? null,
            'district_id' => $input['district_id'],
            'gn_division_id' => $input['gn_division_id'],
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
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Patient not found');
        }


        // Update patient-specific fields
        $patient->blood_group = $input['blood_group'] ?? $patient->blood_group;
        $patient->marital_status = $input['marital_status'] ?? $patient->marital_status;
        $patient->preferred_language = $input['preferred_language'] ?? $patient->preferred_language;
        $patient->occupation = $input['occupation'] ?? $patient->occupation;
        $patient->height = $input['height'] ?? $patient->height;
        $patient->weight = $input['weight'] ?? $patient->weight;
        $patient->past_surgeries = $input['past_surgeries'] ?? $patient->past_surgeries;
        $patient->past_surgeries_details = $input['past_surgeries_details'] ?? $patient->past_surgeries_details;
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

    public function findByUserId($userId)
    {
        return Patient::with('user')->where('user_id', $userId)->first();
    }


    public function updatePatient($id, array $input)
    {
        // Find patient
        $patient = $this->find($id);

        if (!$patient) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Patient not found');
        }

        // Update patient fields
        $patientFields = [
            'blood_group',
            'marital_status',
            'preferred_language',
            'occupation',
            'height',
            'weight',
            'past_surgeries',
            'past_surgeries_details',
            'emergency_person',
            'emergency_relationship',
            'emergency_contact'
        ];

        foreach ($patientFields as $field) {
            if (isset($input[$field])) {
                $patient->$field = $input[$field];
            }
        }

        // Update related user safely
        $user = $patient->user;
        if ($user) {
            $userFields = ['name', 'email', 'dob', 'nic', 'gender', 'phone'];
            foreach ($userFields as $field) {
                if (isset($input[$field])) {
                    $user->$field = $input[$field];
                }
            }

            // Password update if provided and confirmed
            if (!empty($input['password'])) {
                if (!empty($input['password_confirmation']) && $input['password'] === $input['password_confirmation']) {
                    $user->password = bcrypt($input['password']);
                } else {
                    throw new \Exception('Password confirmation does not match.');
                }
            }

            // Image upload path (assuming path is already handled)
            if (!empty($input['image_path'])) {
                $user->image_path = $input['image_path'];
            }

            $user->save(); // Save user first to ensure foreign key consistency
        } else {
            throw new \Exception('Linked user not found for this patient.');
        }

        $patient->save(); // Save patient

        return $patient;
    }
}
