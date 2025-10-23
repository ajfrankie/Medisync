<?php

namespace App\Repositories;

use App\Models\Nurse;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NurseRepository
{
    protected $model;

    public function __construct(Nurse $nurse)
    {
        $this->model = $nurse;
    }

    public function get(Request $request)
    {
        $query = Nurse::with('user')
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
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department', 'LIKE', "%{$request->department}%");
            });
        }

        if (!empty($request->shift_time)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('shift_time', 'LIKE', "%{$request->shift_time}%");
            });
        }


        if ($request->has('is_activated')) {
            $query->where('is_activated', (bool) $request->is_activated);
        }

        return $query;
    }

    public function create(array $input): Nurse
    {
        // Ensure user_id is present
        if (empty($input['user_id'])) {
            throw new \InvalidArgumentException('User ID is required to create a Doctor record.');
        }

        // Create Doctor record linked to existing user
        return Nurse::create([
            'user_id'        => $input['user_id'],
            'shift_time' => $input['shift_time'],
            'department'     => $input['department'],
            'experience'     => $input['experience'] ?? null,
            'is_activated'   => true,
        ]);
    }

    public function find($id)
    {
        return Nurse::with('user')->find($id);
    }

    public function update($id, array $input)
    {
        $nurse = $this->find($id);
        if (!$nurse) {
            throw new ModelNotFoundException('nurse not found');
        }


        $user = $nurse->user;
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

        return $nurse;
    }

    public function delete($id)
    {
        $nurse = $this->find($id);
        if ($nurse) {
            $nurse->delete();
        }
    }

    public function deactivate($id)
    {
        $nurse = $this->find($id);
        if ($nurse) {
            $nurse->is_activated = false;
            $nurse->save();
            return $nurse;
        }

        throw new \Exception('nurse not found');
    }

    public function activate($id)
    {
        $nurse = $this->find($id);
        if ($nurse) {
            $nurse->is_activated = true;
            $nurse->save();
            return $nurse;
        }

        throw new \Exception('nurse not found');
    }
}
