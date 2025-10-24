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
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        {{-- Profile Image --}}
                        <div class="me-3">
                            @php
                                $avatar = $patient->user->image_path
                                    ? asset('storage/' . $patient->user->image_path)
                                    : asset('assets/images/default-avatar.png');
                            @endphp
                            <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle" width="120" height="120"
                                style="object-fit: cover; border: 3px solid #0d6efd;">
                        </div>

                        {{-- Name & Email --}}
                        <div>
                            <h3 class="mb-1">{{ $patient->user->name }}</h3>
                            <p class="text-muted mb-0">{{ $patient->user->email }}</p>
                        </div>
                    </div>

                    <hr>

                    {{-- Patient Info Grid --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Phone:</strong> <span class="text-primary">{{ $patient->user->phone ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>NIC:</strong> <span class="text-primary">{{ $patient->user->nic ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Gender:</strong> <span
                                    class="badge bg-info">{{ ucfirst($patient->user->gender ?? '-') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>DOB:</strong> <span class="text-success">{{ $patient->user->dob ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Blood Group:</strong> <span
                                    class="badge bg-danger">{{ $patient->blood_group ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Marital Status:</strong> <span>{{ $patient->marital_status ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Occupation:</strong> <span>{{ $patient->occupation ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Height:</strong> <span>{{ $patient->height ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Weight:</strong> <span>{{ $patient->weight ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Past Surgeries:</strong> <span>{{ $patient->past_surgeries ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Past Surgeries Details:</strong>
                                <span>{{ $patient->past_surgeries_details ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Preferred Language:</strong> <span>{{ $patient->preferred_language ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Address:</strong> <span>{{ $patient->address ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Emergency Person:</strong> <span>{{ $patient->emergency_person ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Relationship:</strong> <span>{{ $patient->emergency_relationship ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <strong>Emergency Contact:</strong> <span
                                    class="text-warning">{{ $patient->emergency_contact ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.patient.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="ri-arrow-go-back-line"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
