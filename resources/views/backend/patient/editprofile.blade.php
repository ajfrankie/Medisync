@extends('backend.layouts.master')

@section('title', 'Edit Patient Profile')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Patients
        @endslot
        @slot('title')
            Edit Profile
        @endslot
    @endcomponent

    <form action="{{ route('admin.patient.updatePatient', $patient->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @php
            $user = $patient->user;
            $avatar = $user->image_path ? asset('storage/' . $user->image_path) : null;
            $initials = strtoupper(substr($user->name ?? '', 0, 2));
        @endphp

        {{-- User Info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body row align-items-center">
                <div class="col-md-4 text-center mb-3">
                    @if ($avatar)
                        <img src="{{ $avatar }}" class="rounded-circle mb-2" width="120" height="120"
                            style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2"
                            style="width:120px; height:120px; font-size:36px; font-weight:bold;">
                            {{ $initials }}
                        </div>
                    @endif
                    <input type="file" name="image_path" class="form-control form-control-sm mt-2">
                </div>
                <di<div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ $user->name ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" value="{{ $user->phone ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" value="{{ $user->dob ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIC</label>
                            <input type="text" class="form-control" value="{{ $user->nic ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->gender) ?? '-' }}" readonly>
                        </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                    placeholder="Leave blank to keep current password">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
            </div>
        </div>
        </div>
        </div>
        </div>

        {{-- Patient Info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-dark">
                <h5 class="mb-0">Patient Details</h5>
            </div>
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Blood Group</label>
                        <input type="text" name="blood_group" class="form-control"
                            value="{{ $patient->blood_group ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Height (cm)</label>
                        <input type="number" name="height" class="form-control" value="{{ $patient->height ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" name="weight" class="form-control" value="{{ $patient->weight ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Past Surgeries</label>
                        <input type="text" name="past_surgeries" class="form-control"
                            value="{{ $patient->past_surgeries ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Surgery Details</label>
                        <textarea name="past_surgeries_details" class="form-control">{{ $patient->past_surgeries_details ?? '' }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Marital Status</label>
                        <input type="text" name="marital_status" class="form-control"
                            value="{{ $patient->marital_status ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preferred Language</label>
                        <input type="text" name="preferred_language" class="form-control"
                            value="{{ $patient->preferred_language ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Occupation</label>
                        <input type="text" name="occupation" class="form-control"
                            value="{{ $patient->occupation ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Emergency Person</label>
                        <input type="text" name="emergency_person" class="form-control"
                            value="{{ $patient->emergency_person ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Relationship</label>
                        <input type="text" name="emergency_relationship" class="form-control"
                            value="{{ $patient->emergency_relationship ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Emergency Contact</label>
                        <input type="text" name="emergency_contact" class="form-control"
                            value="{{ $patient->emergency_contact ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="text-end mb-4">
            <a href="{{ route('admin.patient.showPatient', $patient->id) }}" class="btn btn-outline-secondary me-2">
                <i class="bx bx-left-arrow-alt"></i> Back
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bx bx-save"></i> Save Changes
            </button>
        </div>
    </form>
@endsection
