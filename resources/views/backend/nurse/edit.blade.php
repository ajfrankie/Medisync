@extends('backend.layouts.master')

@section('title')
    Nurse Edit
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
                        <input type="hidden" name="role" value="nurse">

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        <div class="row">

                            <!-- Nurse Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nurse's Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name', $nurse->user->name) }}" readonly>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Shift Time -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="shift_time" class="form-label">Nurse's Shift Time</label>
                                    <select id="shift_time"
                                        class="form-control select2 @error('shift_time') is-invalid @enderror"
                                        name="shift_time" required>
                                        <option value="" disabled>Choose...</option>
                                        @foreach (['Morning (6 AM - 2 PM)', 'Afternoon (2 PM - 10 PM)', 'Night (10 PM - 6 AM)'] as $shift)
                                            <option value="{{ $shift }}"
                                                {{ old('shift_time', $nurse->shift_time) == $shift ? 'selected' : '' }}>
                                                {{ $shift }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shift_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <select id="department"
                                        class="form-control select2 @error('department') is-invalid @enderror"
                                        name="department">
                                        <option value="" disabled>Choose...</option>
                                        @foreach (['Emergency', 'ICU', 'Cardiology', 'Neurology', 'Oncology', 'Orthopedics', 'Pediatrics', 'OB/GYN', 'Surgery', 'Radiology', 'Pathology/Laboratory', 'Gastroenterology', 'Pulmonology', 'Nephrology', 'Endocrinology', 'Dermatology', 'Psychiatry/MentalHealth', 'Ophthalmology', 'ENT', 'Physical Therapy/Rehabilitation', 'Pharmacy', 'Urology', 'HospiceCare'] as $dept)
                                            <option value="{{ $dept }}"
                                                {{ old('department', $nurse->department) == $dept ? 'selected' : '' }}>
                                                {{ $dept }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Experience -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="experience" class="form-label">Experience (years)</label>
                                    <input type="number" class="form-control @error('experience') is-invalid @enderror"
                                        name="experience" id="experience" placeholder="Enter experience"
                                        value="{{ old('experience', $nurse->experience) }}">
                                    @error('experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.nurse.index') }}"
                                class="btn btn-outline-danger custom-cancel-btn">Cancel</a>
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
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select",
                allowClear: true
            });
        });
    </script>
@endsection
