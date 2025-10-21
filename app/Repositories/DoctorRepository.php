<?php

namespace App\Repositories;

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
        $query = Doctor::with('user')
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


        if (!empty($request->department)) {
            $query->where('department', 'LIKE', "%{$request->department}%");
        }

        if (!empty($request->specialization)) {
            $query->where('specialization', 'LIKE', "%{$request->specialization}%");
        }


        if ($request->has('is_activated')) {
            $query->where('is_activated', (bool) $request->is_activated);
        }

        return $query;
    }

    public function create(array $input): Doctor
    {
        $doctorRole = Role::where('role_name', 'Doctor')->firstOrFail();

        $user = User::create([
            'role_id'  => $doctorRole->id,
            'name'     => $input['name'],
            'email'    => $input['email'],
            'nic'   => $input['nic'] ?? null,
            'dob'   => $input['dob'] ?? null,
            'gender'   => $input['gender'] ?? null,
            'image_path'   => $input['image_path'] ?? null,
            'password' => Hash::make($input['password']),
            'phone'    => $input['phone'] ?? null,
        ]);

        return Doctor::create([
            'id'             => Str::uuid(),
            'user_id'        => $user->id,
            'specialization' => $input['specialization'],
            'department'     => $input['department'],
            'experience'     => $input['experience'] ?? null,
            'is_activated'   => true,
        ]);
    }

    public function find($id)
    {
        return Doctor::with('user')->find($id);
    }

    public function update($id, array $input)
    {
        $doctor = $this->find($id);
        if (!$doctor) {
            throw new ModelNotFoundException('Doctor not found');
        }


        $user = $doctor->user;
        if ($user) {
            $user->name = $input['name'] ?? $user->name;
            $user->email = $input['email'] ?? $user->email;
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

        $doctor->update([
            'specialization' => $input['specialization'] ?? $doctor->specialization,
            'department'     => $input['department'] ?? $doctor->department,
            'experience'     => $input['experience'] ?? $doctor->experience,
        ]);

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

        throw new \Exception('Doctor not found');
    }

    public function activate($id)
    {
        $doctor = $this->find($id);
        if ($doctor) {
            $doctor->is_activated = true;
            $doctor->save();
            return $doctor;
        }

        throw new \Exception('Doctor not found');
    }
}
