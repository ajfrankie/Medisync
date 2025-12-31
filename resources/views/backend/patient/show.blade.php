@extends('backend.layouts.master')

@section('title', 'Patient Details')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Patient
        @endslot
        @slot('title')
            Details
        @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Profile Section --}}
            <div class="card shadow-sm border-0 mb-4">
                @php
                    $user = $patient->user;
                    $avatar = $user->image_path ? asset('storage/' . $user->image_path) : null;
                    $initials = strtoupper(substr($user->name ?? '', 0, 2));

                    // BMI Badge color
                    $bmiClass = match ($bmiData['category'] ?? '') {
                        'Underweight' => 'bg-warning',
                        'Normal' => 'bg-success',
                        'Overweight' => 'bg-warning',
                        'Obese' => 'bg-danger',
                        default => 'bg-secondary',
                    };
                @endphp

                <d<div class="card-body d-flex align-items-center flex-column flex-md-row text-center text-md-start">
                    {{-- Avatar / Initials --}}
                    <div class="me-md-4 mb-3 mb-md-0">
                        @if ($avatar)
                            <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle border border-primary"
                                width="120" height="120" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width: 120px; height: 120px; font-size: 36px; font-weight: bold;">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>

                    {{-- User Details --}}
                    <div class="flex-grow-1">
                        <h3 class="mb-1">{{ $user->name }}</h3>
                        <p class="text-muted mb-2">{{ $user->email }}</p>
                        <div class="d-flex justify-content-center justify-content-md-start flex-wrap gap-2">
                            <span class="badge bg-success">Age: {{ $age ?? 'N/A' }}</span>
                            <span class="badge {{ $bmiClass }}">BMI: {{ $bmiData['bmi'] ?? 'N/A' }}
                                ({{ $bmiData['category'] ?? '-' }})</span>
                            <span class="badge bg-danger">Blood Group: {{ $patient->blood_group ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Add Supportive Document Button --}}
                    <div class="ms-md-3 mt-3 mt-md-0">
                        <a href="{{ route('admin.document.create', ['patient_id' => $patient->id]) }}"
                            class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="bx bx-file-plus"></i> Add Supportive Document
                        </a>
                    </div>
            </div>

        </div>

        {{-- Personal Information --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <i class="ri-user-3-line me-2"></i> Personal Information
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <i class="ri-phone-line me-1 text-primary"></i>
                    <strong>Phone:</strong> <span class="text-primary">{{ $user->phone ?? '-' }}</span>
                </div>
                <div class="col-md-6">
                    <i class="ri-id-card-line me-1 text-primary"></i>
                    <strong>NIC:</strong> <span>{{ $user->nic ?? '-' }}</span>
                </div>
                <div class="col-md-6">
                    <i class="ri-genderless-line me-1 text-info"></i>
                    <strong>Gender:</strong>
                    <span class="badge bg-info">{{ ucfirst($user->gender ?? '-') }}</span>
                </div>
                <div class="col-md-6">
                    <i class="ri-calendar-line me-1 text-success"></i>
                    <strong>DOB:</strong> <span>{{ $user->dob ?? '-' }}</span>
                </div>
                <div class="col-md-6">
                    <i class="ri-heart-line me-1 text-warning"></i>
                    <strong>Marital Status:</strong> <span>{{ $patient->marital_status ?? '-' }}</span>
                </div>
                <div class="col-md-6">
                    <i class="ri-home-line me-1 text-secondary"></i>
                    <strong>Address:</strong> <span>{{ $patient->address ?? '-' }}</span>
                </div>
                <div class="col-md-6">
                    <i class="ri-global-line me-1 text-muted"></i>
                    <strong>Preferred Language:</strong> <span>{{ $patient->preferred_language ?? '-' }}</span>
                </div>
                <div class="col-md-6">
                    <i class="ri-briefcase-line me-1 text-dark"></i>
                    <strong>Occupation:</strong> <span>{{ $patient->occupation ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Health Information --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white">
                <i class="ri-stethoscope-line me-2"></i> Health Information
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6"><strong>Height:</strong> <span>{{ $patient->height ?? '-' }}</span></div>
                <div class="col-md-6"><strong>Weight:</strong> <span>{{ $patient->weight ?? '-' }}</span></div>
                <div class="col-md-6"><strong>Past Surgeries:</strong>
                    <span>{{ $patient->past_surgeries ?? '-' }}</span>
                </div>
                <div class="col-md-6"><strong>Past Surgeries Details:</strong>
                    <span>{{ $patient->past_surgeries_details ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Emergency Contact --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-warning text-dark">
                <i class="ri-emergency-line me-2"></i> Emergency Contact
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6"><strong>Emergency Person:</strong>
                    <span>{{ $patient->emergency_person ?? '-' }}</span>
                </div>
                <div class="col-md-6"><strong>Relationship:</strong>
                    <span>{{ $patient->emergency_relationship ?? '-' }}</span>
                </div>
                <div class="col-md-6"><strong>Emergency Contact:</strong>
                    <span class="text-danger">{{ $patient->emergency_contact ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- EHR Details --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-info text-dark d-flex align-items-center">
                <i class="ri-folder-info-line me-2 fs-5"></i>
                <span class="fw-semibold">EHR Details</span>
            </div>
            <div class="card-body">
                @if ($ehrRecords->count() > 0)
                    <h5 class="mb-3">EHR Records</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($ehrRecords as $ehr)
                            <a href="{{ route('admin.ehr.show', $ehr->id) }}" class="btn btn-outline-info btn-sm">
                                <i class="ri-file-list-line me-1"></i>
                                View EHR ({{ $ehr->visit_date ?? 'No date' }})
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No EHR records found for this patient.</p>
                @endif
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('admin.patient.index') }}" class="btn btn-outline-danger btn-lg">
                <i class="ri-arrow-go-back-line me-1"></i> Back to List
            </a>
            <a href="{{ route('admin.ehr.create', ['patient_id' => $patient->id]) }}"
                class="btn btn-outline-success btn-lg">
                <i class="ri-add-line me-1"></i> Create EHR
            </a>
        </div>

    </div>
    </div>
@endsection
