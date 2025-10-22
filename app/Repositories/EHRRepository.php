<?php

namespace App\Repositories;

use App\Models\EhrRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EHRRepository
{
    protected $model;

    public function __construct(EhrRecord $ehrRecord)
    {
        $this->model = $ehrRecord;
    }

    public function get(Request $request)
    {
        $query = EhrRecord::with('doctor.user', 'patient.user')
            ->orderBy('created_at', 'desc');

        if (!empty($request->name)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->name}%");
            });
        }

        return $query;
    }

    public function create(array $input): EhrRecord
    {
        return EhrRecord::create([
            'doctor_id'         => Auth::user()->doctor->id ?? null, // fetch doctor's ID
            'patient_id'        => $input['patient_id'],
            'visit_date'        => $input['visit_date'],
            'diagnosis'         => $input['diagnosis'],
            'treatment_summary' => $input['treatment_summary'] ?? null,
            'next_visit_date'   => $input['next_visit_date'] ?? null,
            'is_activated'      => true,
        ]);
    }


    public function find($id)
    {
        return EhrRecord::find($id);
    }

    public function update($id, array $input)
    {
        $ehrRecord = $this->find($id);

        if (!$ehrRecord) {
            throw new ModelNotFoundException("EHR Record not found");
        }

        // Ensure we use the doctor's ID, not the user ID
        $doctorId = Auth::user()->doctor->id ?? null;

        if (!$doctorId) {
            throw new \Exception("Authenticated user is not linked to a doctor profile.");
        }

        $ehrRecord->update([
            'doctor_id'         => $doctorId, // logged-in doctor's ID
            'patient_id'        => $input['patient_id'] ?? $ehrRecord->patient_id,
            'visit_date'        => $input['visit_date'] ?? $ehrRecord->visit_date,
            'diagnosis'         => $input['diagnosis'] ?? $ehrRecord->diagnosis,
            'treatment_summary' => $input['treatment_summary'] ?? $ehrRecord->treatment_summary,
            'next_visit_date'   => $input['next_visit_date'] ?? $ehrRecord->next_visit_date,
        ]);

        return $ehrRecord;
    }

    public function delete($id)
    {
        $ehrRecord = $this->find($id);
        if ($ehrRecord) {
            $ehrRecord->delete();
        }
    }

    public function deactivate($id)
    {
        $ehrRecord = $this->find($id);
        if ($ehrRecord) {
            $ehrRecord->is_activated = false;
            $ehrRecord->save();
            return $ehrRecord;
        }

        throw new \Exception('EHR Record not found');
    }

    public function activate($id)
    {
        $ehrRecord = $this->find($id);
        if ($ehrRecord) {
            $ehrRecord->is_activated = true;
            $ehrRecord->save();
            return $ehrRecord;
        }

        throw new \Exception('EHR Record not found');
    }
}
