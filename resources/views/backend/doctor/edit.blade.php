@extends('backend.layouts.master')

@section('title')
    Edit Doctor
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Doctors
        @endslot
        @slot('title')
            Edit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.doctor.update', $doctor->id) }}">
                        @csrf
                        @method('PUT')

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        <div class="row">
                            <!-- Doctor Name -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Doctor's Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name', $doctor->user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email', $doctor->user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Enter new password">
                                    <small class="text-muted">Leave blank to keep current password</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" id="phone" value="{{ old('phone', $doctor->user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Specialization -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="specialization" class="form-label">Specialization</label>
                                    <select id="specialization"
                                        class="form-control select2 @error('specialization') is-invalid @enderror"
                                        name="specialization">
                                        <option disabled value="">Choose...</option>
                                        @php
                                            $specializations = [
                                                'general_medicine' => 'General Medicine',
                                                'cardiology' => 'Cardiology',
                                                'neurology' => 'Neurology',
                                                'oncology' => 'Oncology',
                                                'orthopedics' => 'Orthopedics',
                                                'pediatrics' => 'Pediatrics',
                                                'obgyn' => 'OB/GYN',
                                                'surgery' => 'Surgery',
                                                'radiology' => 'Radiology',
                                                'pathology' => 'Pathology / Laboratory',
                                                'gastroenterology' => 'Gastroenterology',
                                                'pulmonology' => 'Pulmonology',
                                                'nephrology' => 'Nephrology',
                                                'endocrinology' => 'Endocrinology',
                                                'dermatology' => 'Dermatology',
                                                'psychiatry' => 'Psychiatry / Mental Health',
                                                'ophthalmology' => 'Ophthalmology',
                                                'ent' => 'ENT',
                                                'rehabilitation' => 'Physical Therapy / Rehabilitation',
                                                'pharmacy' => 'Pharmacy',
                                                'urology' => 'Urology',
                                                'palliative' => 'Palliative / Hospice Care',
                                            ];
                                        @endphp

                                        @foreach ($specializations as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('specialization', $doctor->specialization) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specialization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select id="department"
                                        class="form-control select2 @error('department') is-invalid @enderror"
                                        name="department">
                                        <option disabled value="">Choose...</option>
                                        @foreach ($specializations as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('department', $doctor->department) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Experience -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="experience" class="form-label">Experience (years)</label>
                                    <input type="number" class="form-control @error('experience') is-invalid @enderror"
                                        name="experience" id="experience"
                                        value="{{ old('experience', $doctor->experience) }}">
                                    @error('experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-danger">Cancel</a>
                            <button type="submit" class="btn btn-secondary w-md">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>
@endsection
