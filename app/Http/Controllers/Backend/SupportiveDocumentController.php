<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SupportiveDocumentRepository;
use App\Models\Patient;
use App\Models\SupportiveDocument;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\Storage;

class SupportiveDocumentController extends Controller
{
    protected $supportiveDocumentRepository;

    public function __construct(SupportiveDocumentRepository $supportiveDocumentRepository)
    {
        $this->supportiveDocumentRepository = $supportiveDocumentRepository;
    }


    public function index(Request $request)
    {
        $documents = app(SupportiveDocumentRepository::class)
            ->get($request)
            ->paginate(5);

        return view('backend.documents.index', [
            'documents' => $documents,
            'request' => $request,
        ]);
    }

    /**
     * Show the form to create a new supportive document.
     */
    public function create($patient_id)
    {
        return view('backend.documents.create', compact('patient_id'));
    }




    /**
     * Store a newly created supportive document using repository.
     */
    public function store(Request $request)
    {
        // Automatically get patient_id from logged-in user
        $patient_id = auth()->user()->patient->id ?? null;

        // Validate other fields (no need to require patient_id from form)
        $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'description' => 'nullable|string',
        ]);

        // Handle file upload
        $file = $request->file('file_path');
        $path = $file->store('supportive_documents', 'public');

        // Save via repository
        $this->supportiveDocumentRepository->create([
            'patient_id'  => $patient_id, // ✅ auto-filled
            'title'       => $request->title,
            'file_path'   => $path,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.document.index')
            ->with('success', 'Supportive document added successfully!');
    }

    /**
     * Display a specific supportive document.
     */
    public function show($patient_id)
    {
        $documents = app(SupportiveDocumentRepository::class)->getByPatientId($patient_id);

        // Always return the page, even if no documents exist
        return view('backend.documents.show', compact('documents', 'patient_id'));
    }
}
