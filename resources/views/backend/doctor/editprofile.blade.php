@extends('backend.layouts.master')

@section('title')
    Edit Doctor Profile
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Doctors
        @endslot
        @slot('title')
            Edit Profile
        @endslot
    @endcomponent

    <form action="{{ route('admin.doctor.updateDoctor', $doctor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @php
            $user = $doctor->user ?? null;
        @endphp

        {{-- User Info --}}
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
                        <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle mb-2" width="120" height="120" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2"
                             style="width:120px; height:120px; font-size:36px; font-weight:bold;">
                            {{ $initials }}
                        </div>
                    @endif
                    <input type="file" name="image_path" class="form-control form-control-sm mt-2">
                </div>

                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" value="{{ $user->dob ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="nic" class="form-label">NIC</label>
                        <input type="text" name="nic" class="form-control" value="{{ $user->nic ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ ($user->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ ($user->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ ($user->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                    </div>
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
                    <div class="mb-3">
                        <label for="specialization" class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control" value="{{ $doctor->specialization ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" name="department" class="form-control" value="{{ $doctor->department ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="experience" class="form-label">Experience (years)</label>
                        <input type="number" name="experience" class="form-control" value="{{ $doctor->experience ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="text-end mb-4">
            <a href="{{ route('admin.doctor.showDoctor', $doctor->id) }}" class="btn btn-outline-secondary me-2">
                <i class="bx bx-left-arrow-alt"></i> Back
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bx bx-save"></i> Save Changes
            </button>
        </div>
    </form>
@endsection
