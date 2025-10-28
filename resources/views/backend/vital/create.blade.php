@extends('backend.layouts.master')

@section('title')
    Vital Create
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
            Create
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('admin.vital.store') }}">
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

                        <!-- Create Post Form -->

                        <div class="row mt-4">

                            <!-- Temperature -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="temperature" class="form-label">Temperature (°C)</label>
                                    <input type="number" step="0.1"
                                        class="form-control @error('temperature') is-invalid @enderror" name="temperature"
                                        id="temperature" placeholder="e.g. 36.7">
                                    @error('temperature')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Blood Pressure -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="blood_pressure" class="form-label">Blood Pressure (mmHg)</label>
                                    <input type="text" class="form-control @error('blood_pressure') is-invalid @enderror"
                                        name="blood_pressure" id="blood_pressure" placeholder="e.g. 120/80">
                                    @error('blood_pressure')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Pulse Rate -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="pulse_rate" class="form-label">Pulse Rate (bpm)</label>
                                    <input type="number" class="form-control @error('pulse_rate') is-invalid @enderror"
                                        name="pulse_rate" id="pulse_rate" placeholder="e.g. 75">
                                    @error('pulse_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Oxygen Level -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="oxygen_level" class="form-label">Oxygen Level (%)</label>
                                    <input type="number" step="0.1"
                                        class="form-control @error('oxygen_level') is-invalid @enderror" name="oxygen_level"
                                        id="oxygen_level" placeholder="e.g. 98">
                                    @error('oxygen_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="blood_sugar" class="form-label">Blood Sugar (mg/dl)</label>
                                    <input type="number" step="0.1"
                                        class="form-control @error('blood_sugar') is-invalid @enderror" name="blood_sugar"
                                        id="blood_sugar" placeholder="e.g. 300 mg/dL">
                                    @error('blood_sugar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <!-- Hidden EHR ID -->
                            <input type="hidden" name="ehr_id" id="ehr_id"
                                value="{{ $vital->ehrRecord->id ?? request()->get('ehr_id') }}">


                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mt-3 mb-3">
                            <a href="{{ route('admin.ehr.index') }}" class="btn btn-outline-danger">
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
