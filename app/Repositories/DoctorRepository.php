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
        $query = Doctor::with('user') // ✅ eager load related user
            ->orderBy('created_at', 'desc');

        if (!empty($request->name)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->name}%");
            });
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

        // ✅ Update related user record
        $user = $doctor->user;
        if ($user) {
            $user->name = $input['name'] ?? $user->name;
            $user->email = $input['email'] ?? $user->email;
            $user->phone = $input['phone'] ?? $user->phone;

            if (!empty($input['password'])) {
                $user->password = Hash::make($input['password']);
            }

            $user->save();
        }

        // ✅ Update doctor-specific fields
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
