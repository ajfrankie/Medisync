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
            Nurse
        @endslot
        @slot('title')
            Create
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.nurse.store') }}">
                        @csrf

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
                                        name="name" id="name" value="{{ old('name') }}" placeholder="Enter name"
                                        required>
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
                                        name="email" id="email" value="{{ old('email') }}" placeholder="Enter email"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" id="phone" value="{{ old('phone') }}" placeholder="Enter phone"
                                        required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Enter password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Shift Time -->
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Nurse's Department</label>
                                    <select id="department"
                                        class="form-control select2 @error('department') is-invalid @enderror"
                                        name="department" required>
                                        <option selected disabled value="">Choose...</option>
                                        <option value="Emergency">Emergency</option>
                                        <option value="ICU">ICU</option>
                                        <option value="Cardiology">Cardiology</option>
                                        <option value="Neurology">Neurology</option>
                                        <option value="Oncology">Oncology</option>
                                        <option value="Orthopedics">Orthopedics</option>
                                        <option value="Pediatrics">Pediatrics</option>
                                        <option value="OB/GYN">OB/GYN</option>
                                        <option value="Surgery">Surgery</option>
                                        <option value="Radiology">Radiology</option>
                                        <option value="Pathology">Pathology / Laboratory</option>
                                        <option value="Gastroenterology">Gastroenterology</option>
                                        <option value="Pulmonology">Pulmonology</option>
                                        <option value="Nephrology">Nephrology</option>
                                        <option value="Endocrinology">Endocrinology</option>
                                        <option value="Dermatology">Dermatology</option>
                                        <option value="Psychiatry">Psychiatry</option>
                                        <option value="Ophthalmology">Ophthalmology</option>
                                        <option value="ENT">ENT</option>
                                        <option value="Physical Therapy">Physical Therapy</option>
                                        <option value="Pharmacy">Pharmacy</option>
                                        <option value="Urology">Urology</option>
                                        <option value="Palliative">Palliative</option>
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.nurse.index') }}" class="btn btn-outline-danger">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-outline-secondary w-md">Create</button>
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
    <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
@endsection
