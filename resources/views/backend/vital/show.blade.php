@extends('backend.layouts.master')

@section('title')
    Vital Details
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Vital
        @endslot
        @slot('title')
            View
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success mt-2">{{ session('success') }}</div>
                    @elseif (session('error'))
                        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                    @endif

                    <div class="row mt-4">
                        <!-- Temperature -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Temperature (°C)</label>
                                <input type="text" class="form-control" value="{{ $vital->temperature ?? '-' }}"
                                    readonly>
                            </div>
                        </div>

                        <!-- Blood Pressure -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Blood Pressure (mmHg)</label>
                                <input type="text" class="form-control" value="{{ $vital->blood_pressure ?? '-' }}"
                                    readonly>
                            </div>
                        </div>

                        <!-- Pulse Rate -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Pulse Rate (bpm)</label>
                                <input type="text" class="form-control" value="{{ $vital->pulse_rate ?? '-' }}"
                                    readonly>
                            </div>
                        </div>

                        <!-- Oxygen Level -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Oxygen Level (%)</label>
                                <input type="text" class="form-control" value="{{ $vital->oxygen_level ?? '-' }}"
                                    readonly>
                            </div>
                        </div>

                        <!-- Blood Sugar -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Blood Sugar (mg/dl)</label>
                                <input type="text" class="form-control" value="{{ $vital->blood_sugar ?? '-' }}"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="vital_id" value="{{ $vital->id }}">

                    <!-- Buttons -->
                    <div class="text-end pe-3 mt-4">


                        @php
                            $user = auth()->user();
                        @endphp
                        @if ($user->role->role_name == 'Doctor')
                            <a href="{{ route('admin.prescription.create', ['vital_id' => $vital->id]) }}"
                                class="btn btn-outline-primary me-2">
                                <i class="ri-file-add-line"></i> Add Prescription
                            </a>
                        @endif

                        @if ($user->role->role_name == 'Doctor')
                            <a href="{{ route('admin.vital.create', ['ehr_id' => $vital->ehr_id]) }}"
                                class="btn btn-outline-secondary me-2">
                                <i class="ri-add-line"></i> Add Vital
                            </a>
                        @endif

                        <a href="{{ route('admin.ehr.index') }}" class="btn btn-outline-danger">
                            Back
                        </a>
                    </div>

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
