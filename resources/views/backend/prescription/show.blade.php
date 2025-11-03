@extends('backend.layouts.master')

@section('title')
    Prescription Details
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Prescription
        @endslot
        @slot('title')
            View
        @endslot
    @endcomponent

    @php
        $firstPrescription = $prescriptionsByDate->first()->first();
        $dob = $firstPrescription->vital->ehrRecord->patient->user->dob ?? null;
        $age = $dob ? \Carbon\Carbon::parse($dob)->age : '-';
    @endphp

    <div class="row mb-4">
        {{-- Patient Info --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Patient Information</h5>
                    <p><strong>Name:</strong> {{ $firstPrescription->vital->ehrRecord->patient->user->name ?? '-' }}</p>
                    <p><strong>Age:</strong> {{ $age }}</p>
                </div>
            </div>
        </div>

        {{-- Doctor Info --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Doctor Information</h5>
                    <p><strong>Name:</strong> {{ $firstPrescription->vital->ehrRecord->doctor->user->name ?? '-' }}</p>
                    <p><strong>Department:</strong> {{ $firstPrescription->vital->ehrRecord->doctor->department ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    @foreach ($prescriptionsByDate as $date => $prescriptions)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-info text-dark d-flex align-items-center">
                <i class="ri-file-list-line me-2 fs-5"></i>
                <span class="fw-semibold">Prescriptions on {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}</span>
            </div>

            <div class="card-body">
                @php
                    $hasMedicines = $prescriptions->filter(function ($p) {
                        return $p->medicine_name || $p->dosage || $p->frequency || $p->duration || $p->instructions;
                    })->isNotEmpty();

                    $imageOnly = $prescriptions->filter(function ($p) {
                        return $p->prescription_img_path && !$p->medicine_name && !$p->dosage && !$p->frequency && !$p->duration;
                    });
                @endphp

                @if ($hasMedicines)
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Dosage</th>
                                    <th>Frequency</th>
                                    <th>Duration</th>
                                    <th>Instructions</th>
                                    <th>Prescription Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prescriptions as $prescription)
                                    @if ($prescription->medicine_name || $prescription->dosage)
                                        <tr>
                                            <td>{{ $prescription->medicine_name ?? '-' }}</td>
                                            <td>{{ $prescription->dosage ?? '-' }}</td>
                                            <td>{{ $prescription->frequency ?? '-' }}</td>
                                            <td>{{ $prescription->duration ?? '-' }}</td>
                                            <td>{{ $prescription->instructions ?? '-' }}</td>
                                            <td class="text-center">
                                                @if ($prescription->prescription_img_path)
                                                    <img src="{{ asset('storage/' . $prescription->prescription_img_path) }}"
                                                        alt="Prescription Image"
                                                        class="img-thumbnail rounded shadow-sm"
                                                        style="max-width: 100px;">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if (!$hasMedicines && $imageOnly->isNotEmpty())
                    <div class="text-center mt-3">
                        @foreach ($imageOnly as $prescription)
                            <div class="d-inline-block mx-2">
                                <img src="{{ asset('storage/' . $prescription->prescription_img_path) }}"
                                     alt="Prescription Image"
                                     class="img-thumbnail rounded shadow-sm"
                                     style="max-width: 250px;">
                                <p class="mt-2 text-muted">Image uploaded on {{ $prescription->created_at->format('Y-m-d') }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!$hasMedicines && $imageOnly->isEmpty())
                    <p class="text-muted text-center mb-0">No prescription details found for this date.</p>
                @endif
            </div>
        </div>
    @endforeach

    {{-- Back Button --}}
    <div class="text-end mb-4">
        <a href="{{ route('admin.ehr.index') }}" class="btn btn-outline-danger">Back</a>
    </div>
@endsection
