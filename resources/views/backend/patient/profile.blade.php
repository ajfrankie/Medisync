@extends('backend.layouts.master')

@section('title')
    Patient Profile
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Patients
        @endslot
        @slot('title')
            Profile
        @endslot
    @endcomponent

    @php
        $user = $patient->user ?? null;
        $dob = $user->dob ?? null;
        $age = $dob ? \Carbon\Carbon::parse($dob)->age : '-';
        $avatar = $user->image_path ? asset('storage/' . $user->image_path) : null;
        $initials = strtoupper(substr($user->name ?? '', 0, 2));
    @endphp

    {{-- Top Card: User Info --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex align-items-center flex-column flex-md-row text-center text-md-start">
            <div class="me-md-4 mb-3 mb-md-0">
                @if ($avatar)
                    <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle border border-primary" width="120"
                        height="120" style="object-fit: cover;">
                @else
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                        style="width: 120px; height: 120px; font-size: 36px; font-weight: bold;">
                        {{ $initials }}
                    </div>
                @endif
            </div>
            <div>
                <h4 class="mb-1">{{ $user->name ?? '-' }}</h4>
                <p class="mb-0 text-muted">{{ $user->email ?? '-' }}</p>
                <p class="mb-0 text-muted">{{ $user->phone ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Patient Details --}}
    <div class="row">
        {{-- Personal Info --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-dark">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Age:</strong> {{ $age }}</p>
                    <p><strong>Gender:</strong> {{ $user->gender ?? '-' }}</p>
                    <p><strong>Blood Group:</strong> {{ $patient->blood_group ?? '-' }}</p>
                    <p><strong>Height:</strong> {{ $patient->height ?? '-' }} cm</p>
                    <p><strong>Weight:</strong> {{ $patient->weight ?? '-' }} kg</p>
                    <p><strong>Past Surgeries:</strong> {{ $patient->past_surgeries ?? '-' }}</p>
                    <p><strong>Surgery Details:</strong> {{ $patient->past_surgeries_details ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Emergency Contact --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Emergency Contact</h5>
                </div>
                <div class="card-body">
                    <p><strong>Contact Person:</strong> {{ $patient->emergency_person ?? '-' }}</p>
                    <p><strong>Relationship:</strong> {{ $patient->emergency_relationship ?? '-' }}</p>
                    <p><strong>Phone:</strong> {{ $patient->emergency_contact ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Account Details --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Account Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $user->email ?? '-' }}</p>
                    <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
                    <p><strong>NIC:</strong> {{ $user->nic ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Preferred Language:</strong> {{ $patient->preferred_language ?? '-' }}</p>
                    <p><strong>Marital Status:</strong> {{ $patient->marital_status ?? '-' }}</p>
                    <p><strong>Occupation:</strong> {{ $patient->occupation ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="text-end mb-4">
        <a href="/admin" class="btn btn-outline-secondary me-2">
            <i class="bx bx-left-arrow-alt"></i> Back
        </a>
        <a href="{{ route('admin.patient.editPatient', $patient->id) }}" class="btn btn-outline-primary w-md">
            <i class="fas fa-plus me-1"></i>
            Edit Profile
        </a>
    </div>
@endsection
