<?php

namespace App\Repositories;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrescriptionRepository
{
    protected $model;

    public function __construct(Prescription $prescription)
    {
        $this->model = $prescription;
    }

    public function get(Request $request)
    {
        $query = Prescription::with('vital.ehrRecord.patient.user')
            ->orderBy('created_at', 'desc');


        return $query;
    }

    public function create(array $input): Prescription
    {
        $vitalId = $input['vital_id'] ?? null;

        if (!$vitalId) {
            throw new \Exception('vital_id is required.');
        }

        // Handle image upload (optional)
        $imagePath = null;
        if (isset($input['prescription_img_path']) && $input['prescription_img_path'] instanceof \Illuminate\Http\UploadedFile) {
            $imagePath = $input['prescription_img_path']->store('prescriptions', 'public');
        }

        $lastPrescription = null;

        // If doctor entered multiple medicines
        if (!empty($input['medicine_name']) && is_array($input['medicine_name'])) {
            foreach ($input['medicine_name'] as $key => $name) {
                if (!empty($name)) {
                    $lastPrescription = Prescription::create([
                        'vital_id'              => $vitalId,
                        'medicine_name'         => $name,
                        'dosage'                => $input['dosage'][$key] ?? null,
                        'frequency'             => $input['frequency'][$key] ?? null,
                        'duration'              => $input['duration'][$key] ?? null,
                        'prescription_img_path' => $imagePath,
                        'instructions'          => $input['instructions'][$key] ?? null,
                    ]);
                }
            }
        }

        // If no multiple entries, create one record
        if (!$lastPrescription) {
            $lastPrescription = Prescription::create([
                'vital_id'              => $vitalId,
                'prescription_img_path' => $imagePath,
            ]);
        }

        // Always return a Prescription model
        return $lastPrescription;
    }




    public function find($id)
    {
        return Prescription::with('vital.ehrRecord.patient.user', 'vital.ehrRecord.doctor.user')
            ->where('id', $id)  // Fix: compare 'id' to the given $id
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                // Group by date only (Y-m-d)
                return $item->created_at->format('Y-m-d');
            });
    }



    // public function findWithVital($id)
    // {
    //     return Prescription::with([
    //         'vital.ehrRecord.patient.user',
    //     ])->find($id);
    // }

    public function findByVitalId($vitalId)
    {
        return Prescription::with(['vital.ehrRecord.patient.user', 'vital.ehrRecord.doctor.user'])
            ->where('vital_id', $vitalId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                // Group by date only (Y-m-d)
                return $item->created_at->format('Y-m-d');
            });
    }



    public function update($id, array $input) {}

    public function delete($id)
    {
        $prescription = $this->find($id);
        if ($prescription) {
            $prescription->delete();
        }
    }

    public function deactivate($id)
    {
        $prescription = $this->find($id);
        if ($prescription) {
            $prescription->is_activated = false;
            $prescription->save();
            return $prescription;
        }

        throw new \Exception('prescription not found');
    }

    public function activate($id)
    {
        $prescription = $this->find($id);
        if ($prescription) {
            $prescription->is_activated = true;
            $prescription->save();
            return $prescription;
        }

        throw new \Exception('prescription not found');
    }
}
