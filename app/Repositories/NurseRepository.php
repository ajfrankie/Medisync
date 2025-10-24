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
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Nurse not found');
        }
        // Update nurse-specific fields
        $nurse->shift_time = $input['shift_time'] ?? $nurse->shift_time;
        $nurse->department = $input['department'] ?? $nurse->department;

        $nurse->save();

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

    public function findByUserId($userId)
    {
        return Nurse::with('user')->where('user_id', $userId)->first();
    }
}
