@extends('backend.layouts.master')

@section('title')
    Doctor Profile
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Doctors
        @endslot
        @slot('title')
            Profile
        @endslot
    @endcomponent

    @php
        $user = $doctor->user ?? null;
    @endphp

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">User Information</h5>
        </div>
        <div class="card-body row">
            <div class="col-md-4 text-center mb-3">
                @php
                    $avatar = $user->image_path ? asset('storage/' . $user->image_path) : null;
                    $initials = strtoupper(substr($user->name ?? '', 0, 2));
                @endphp
                @if ($avatar)
                    <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle mb-2" width="120" height="120"
                        style="object-fit: cover;">
                @else
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2"
                        style="width:120px; height:120px; font-size:36px; font-weight:bold;">
                        {{ $initials }}
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="mb-3"><strong>Name:</strong> {{ $user->name ?? '' }}</div>
                <div class="mb-3"><strong>Email:</strong> {{ $user->email ?? '' }}</div>
                <div class="mb-3"><strong>Phone:</strong> {{ $user->phone ?? '' }}</div>
                <div class="mb-3"><strong>Date of Birth:</strong> {{ $user->dob ?? '' }}</div>
                <div class="mb-3"><strong>NIC:</strong> {{ $user->nic ?? '' }}</div>
                <div class="mb-3"><strong>Gender:</strong> {{ $user->gender ?? '' }}</div>
            </div>
        </div>
    </div>

    {{-- Doctor Details --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-dark">
            <h5 class="mb-0">Doctor Details</h5>
        </div>
        <div class="card-body row">
            <div class="col-md-6">
                <div class="mb-3"><strong>Specialization:</strong> {{ $doctor->specialization ?? '' }}</div>
                <div class="mb-3"><strong>Department:</strong> {{ $doctor->department ?? '' }}</div>
            </div>
            <div class="col-md-6">
                <div class="mb-3"><strong>Experience (years):</strong> {{ $doctor->experience ?? '' }}</div>
            </div>
        </div>
    </div>

    <div class="text-end mb-4">
        <a href="/admin" class="btn btn-outline-danger me-2">
            <i class="bx bx-left-arrow-alt"></i> Back
        </a>
        <a href="{{ route('admin.doctor.editDoctor', $doctor->id) }}" class="btn btn-outline-success w-md">
            <i class="fas fa-plus me-1"></i>
            Edit Profile
        </a>
    </div>
@endsection
