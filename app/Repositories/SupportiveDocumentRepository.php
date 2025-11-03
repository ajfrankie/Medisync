<?php

namespace App\Repositories;

use App\Models\SupportiveDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupportiveDocumentRepository
{
    protected $model;

    public function __construct(SupportiveDocument $supportiveDocument)
    {
        $this->model = $supportiveDocument;
    }

    /**
     * Get all supportive documents, optionally filtered by patient.
     */
    public function get(Request $request)
    {
        $query = SupportiveDocument::with('patient')
            ->orderBy('created_at', 'desc');

        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        return $query;
    }
    /**
     * Create a new supportive document.
     */
    public function create(array $input): SupportiveDocument
    {
        if (empty($input['patient_id'])) {
            throw new \InvalidArgumentException('Patient ID is required to create a supportive document.');
        }

        return $this->model->create([
            'id'          => (string) Str::uuid(),
            'patient_id'  => $input['patient_id'],
            'title'       => $input['title'],
            'file_path'   => $input['file_path'],
            'description' => $input['description'] ?? null,
        ]);
    }

    /**
     * Find a supportive document by ID.
     */
    public function find($id)
    {
        return $this->model->with('patient')->find($id);
    }

    public function getByPatientId($patient_id)
    {
        return SupportiveDocument::with('patient')
            ->where('patient_id', $patient_id)
            ->paginate(5);
    }
}
