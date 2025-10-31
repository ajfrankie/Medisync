<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeDoctorRequest;
use App\Http\Requests\StoreVitalRequest;
use App\Models\User;
use App\Repositories\DoctorRepository;
use App\Repositories\EHRRepository;
use App\Repositories\VitalRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class VitalController extends Controller
{
    protected $doctorRepository;

    public function index(Request $request)
    {
        $ehrId = $request->get('ehr_id');

        $vitals = app(VitalRepository::class)->get($request)->paginate(10);

        $ehr = null;
        if ($ehrId) {
            $ehr = app(EHRRepository::class)->find($ehrId);
            if (!$ehr) {
                return redirect()->back()->with('error', 'EHR record not found.');
            }
        }

        return view('backend.vital.index', [
            'vitals' => $vitals,
            'request' => $request,
            'ehr' => $ehr,
        ]);
    }

    public function create()
    {
        $ehr = app(EHRRepository::class)->find(request()->get('ehr_id'));

        if (!$ehr) {
            return redirect()->back()->with('error', 'EHR record not found.');
        }

        return view('backend.vital.create', [
            'ehr' => $ehr,
        ]);
    }


    public function store(StoreVitalRequest $request)
    {
        try {
            $vital = app(VitalRepository::class)->create($request->validated());

            return redirect()
                ->route('admin.ehr.index')
                ->with('success', 'Vital record created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create vital record: ' . $e->getMessage());
        }
    }


    public function edit(Request $request, $id) {}

    public function update(Request $request, $id) {}

    public function destroy(string $id) {}

    public function show($id, Request $request)
    {
        try {
            $vital = app(VitalRepository::class)->find($id);

            if (!$vital) {
                return redirect()
                    ->route('admin.vital.index')
                    ->with('error', 'Vital order not found.');
            }

            return view('backend.vital.show', [
                'vital' => $vital,
                'request' => $request,
            ]);
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to fetch vital details: ' . $e->getMessage());
        }
    }
}
