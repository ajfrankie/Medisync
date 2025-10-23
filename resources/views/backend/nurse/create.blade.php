@extends('backend.layouts.master')

@section('title')
    Nurse Create
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
            Nurses
        @endslot
        @slot('title')
            Create
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{!! route('admin.nurse.store') !!}">
                        @csrf
                        <input type="hidden" name="role" value="nurse">
                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        <div class="row">

                            <!-- Doctor Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nurse's Name</label>
                                    <select class="form-select select2 @error('user_id') is-invalid @enderror"
                                        id="user_id" name="user_id">
                                        <option value="">Select Nurse...</option>
                                        @foreach ($nurseUsers as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->


                            <!-- Specialization -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shift_time" class="form-label">Nurse's Shift Time</label>
                                    <select id="shift_time"
                                        class="form-control select2 @error('shift_time') is-invalid @enderror"
                                        name="shift_time" required>
                                        <option selected disabled value="">Choose...</option>
                                        <option value="Morning (6 AM - 2 PM)">Morning (6 AM - 2 PM)</option>
                                        <option value="Afternoon (2 PM - 10 PM)">Afternoon (2 PM - 10 PM)</option>
                                        <option value="Night (10 PM - 6 AM)">Night (10 PM - 6 AM)</option>
                                    </select>
                                    @error('shift_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Doctor's Department</label>
                                    <select id="department"
                                        class="form-control select2 @error('department') is-invalid @enderror"
                                        name="department">
                                        <option selected disabled value="">Choose...</option>
                                        <option value="Emergency" {{ old('department') == 'Emergency' ? 'selected' : '' }}>
                                            Emergency</option>
                                        <option value="ICU" {{ old('department') == 'ICU' ? 'selected' : '' }}>ICU
                                        </option>
                                        <option value="Cardiology"
                                            {{ old('department') == 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                                        <option value="Neurology" {{ old('department') == 'Neurology' ? 'selected' : '' }}>
                                            Neurology</option>
                                        <option value="Oncology" {{ old('department') == 'Oncology' ? 'selected' : '' }}>
                                            Oncology</option>
                                        <option value="Orthopedics"
                                            {{ old('department') == 'Orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                                        <option value="Pediatrics"
                                            {{ old('department') == 'Pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                                        <option value="OB/GYN" {{ old('department') == 'OB/GYN' ? 'selected' : '' }}>OB/GYN
                                        </option>
                                        <option value="Surgery" {{ old('department') == 'Surgery' ? 'selected' : '' }}>
                                            Surgery</option>
                                        <option value="Radiology" {{ old('department') == 'Radiology' ? 'selected' : '' }}>
                                            Radiology</option>
                                        <option value="Pathology/Laboratory"
                                            {{ old('department') == 'Pathology/Laboratory' ? 'selected' : '' }}>
                                            Pathology/Laboratory
                                        </option>
                                        <option value="Gastroenterology"
                                            {{ old('department') == 'Gastroenterology' ? 'selected' : '' }}>
                                            Gastroenterology</option>
                                        <option value="Pulmonology"
                                            {{ old('department') == 'Pulmonology' ? 'selected' : '' }}>Pulmonology</option>
                                        <option value="Nephrology"
                                            {{ old('department') == 'Nephrology' ? 'selected' : '' }}>Nephrology</option>
                                        <option value="Endocrinology"
                                            {{ old('department') == 'Endocrinology' ? 'selected' : '' }}>Endocrinology
                                        </option>
                                        <option value="Dermatology"
                                            {{ old('department') == 'Dermatology' ? 'selected' : '' }}>Dermatology</option>
                                        <option value="Psychiatry/MentalHealth"
                                            {{ old('department') == 'Psychiatry/MentalHealth' ? 'selected' : '' }}>
                                            Psychiatry/MentalHealth</option>
                                        <option value="Ophthalmology"
                                            {{ old('department') == 'Ophthalmology' ? 'selected' : '' }}>Ophthalmology
                                        </option>
                                        <option value="ENT" {{ old('department') == 'ENT' ? 'selected' : '' }}>ENT
                                        </option>
                                        <option value="Physical Therapy/Rehabilitation"
                                            {{ old('department') == 'Physical Therapy/Rehabilitation' ? 'selected' : '' }}>
                                            Physical Therapy/Rehabilitation</option>
                                        <option value="Pharmacy" {{ old('department') == 'Pharmacy' ? 'selected' : '' }}>
                                            Pharmacy</option>
                                        <option value="Urology" {{ old('department') == 'Urology' ? 'selected' : '' }}>
                                            Urology</option>
                                        <option value="HospiceCare"
                                            {{ old('department') == 'HospiceCare' ? 'selected' : '' }}>HospiceCare</option>
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Experience -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="experience" class="form-label">Doctor's Experience (years)</label>
                                    <input type="number" class="form-control @error('experience') is-invalid @enderror"
                                        name="experience" id="experience" placeholder="Enter experience"
                                        value="{{ old('experience') }}">
                                    @error('experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-danger custom-cancel-btn">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-outline-secondary w-md">Submit</button>
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
