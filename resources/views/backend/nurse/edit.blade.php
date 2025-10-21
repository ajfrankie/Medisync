@extends('backend.layouts.master')

@section('title')
    Edit Nurse
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Nurse
        @endslot
        @slot('title')
            Edit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.nurse.update', $nurse->id) }}">
                        @csrf
                        @method('PUT')

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Nurse Name -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nurse's Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name', $nurse->user->name) }}"
                                        placeholder="Enter name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email (read-only) -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email"
                                        value="{{ $nurse->user->email }}" readonly>
                                    <small class="text-muted">Email cannot be changed.</small>
                                </div>
                            </div>

                            <!-- Password (editable) -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Enter new password (optional)">
                                    <small class="text-muted">Leave blank to keep current password.</small>
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
                                        name="phone" id="phone" value="{{ old('phone', $nurse->user->phone) }}"
                                        placeholder="Enter phone number">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Shift Time -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="shift_time" class="form-label">Shift Time</label>
                                    <select id="shift_time"
                                        class="form-control select2 @error('shift_time') is-invalid @enderror"
                                        name="shift_time">
                                        <option selected disabled value="">Choose...</option>
                                        <option value="Morning (6 AM - 2 PM)"
                                            {{ old('shift_time', $nurse->shift_time) == 'Morning (6 AM - 2 PM)' ? 'selected' : '' }}>
                                            Morning (6 AM - 2 PM)
                                        </option>
                                        <option value="Afternoon (2 PM - 10 PM)"
                                            {{ old('shift_time', $nurse->shift_time) == 'Afternoon (2 PM - 10 PM)' ? 'selected' : '' }}>
                                            Afternoon (2 PM - 10 PM)
                                        </option>
                                        <option value="Night (10 PM - 6 AM)"
                                            {{ old('shift_time', $nurse->shift_time) == 'Night (10 PM - 6 AM)' ? 'selected' : '' }}>
                                            Night (10 PM - 6 AM)
                                        </option>
                                    </select>
                                    @error('shift_time')
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
                                        <option selected disabled value="">Choose...</option>
                                        @php
                                            $departments = [
                                                'emergency' => 'ED / ER',
                                                'icu' => 'ICU',
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

                                        @foreach ($departments as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('department', $nurse->department) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.nurse.index') }}" class="btn btn-outline-danger">Cancel</a>
                            <button type="submit" class="btn btn-secondary w-md">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>

    <!-- form advanced init -->
    <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
@endsection