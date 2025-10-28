<?php

namespace App\Repositories;

use App\Models\Vital;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VitalRepository
{
    protected $model;

    public function __construct(Vital $vital)
    {
        $this->model = $vital;
    }

    public function get(Request $request)
    {
        $query = Vital::with('ehrRecord') 
            ->orderBy('created_at', 'desc');

        return $query;
    }

    public function create(array $input): Vital
    {
        if (empty($input['ehr_id'])) {
            throw new \InvalidArgumentException('EHR Record is required to create a vital record.');
        }

        return Vital::create([
            'ehr_id'         => $input['ehr_id'],
            'temperature'    => $input['temperature'],
            'blood_pressure' => $input['blood_pressure'],
            'pulse_rate'     => $input['pulse_rate'] ?? null,
            'oxygen_level'   => $input['oxygen_level'] ?? null,
            'recorded_at'    => $input['recorded_at'] ?? now(),
        ]);
    }

    public function find($id)
    {
        return Vital::find($id);
    }

    public function update($id, array $input)
    {
        $vital = $this->find($id);
        if (!$vital) {
            throw new ModelNotFoundException('Vital record not found.');
        }

        $vital->update([
            'temperature'    => $input['temperature'] ?? $vital->temperature,
            'blood_pressure' => $input['blood_pressure'] ?? $vital->blood_pressure,
            'pulse_rate'     => $input['pulse_rate'] ?? $vital->pulse_rate,
            'oxygen_level'   => $input['oxygen_level'] ?? $vital->oxygen_level,
            'recorded_at'    => $input['recorded_at'] ?? $vital->recorded_at,
        ]);

        return $vital;
    }

    public function delete($id)
    {
        $vital = $this->find($id);
        if ($vital) {
            $vital->delete();
        }
    }

    public function deactivate($id)
    {
        $vital = $this->find($id);
        if ($vital) {
            $vital->is_activated = false;
            $vital->save();
            return $vital;
        }

        throw new \Exception('Vital record not found.');
    }

    public function activate($id)
    {
        $vital = $this->find($id);
        if ($vital) {
            $vital->is_activated = true;
            $vital->save();
            return $vital;
        }

        throw new \Exception('Vital record not found.');
    }

    public function findByEhrId($ehrId)
    {
        return Vital::with('ehr')->where('ehr_id', $ehrId)->first();
    }
}
