@extends('backend.layouts.master')

@section('title')
    Appointment Create
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
            Appointment
        @endslot
        @slot('title')
            Create
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('admin.appointment.store') }}">
                        @csrf

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        <div class="row">
                            <!-- Doctor -->
                            <div class="col-xl-3">
                                <div class="mt-3">
                                    <label class="form-label">Doctor's Name</label>
                                    <select class="form-select select2 @error('doctor_id') is-invalid @enderror"
                                        id="doctor_id" name="doctor_id" required>
                                        <option value="">Select Doctor...</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <!-- Patient -->
                            <div class="col-xl-3">
                                <div class="mt-3">
                                    <label class="form-label">Patient's Name</label>
                                    <select class="form-select select2 @error('patient_id') is-invalid @enderror"
                                        id="patient_id" name="patient_id" required>
                                        <option value="">Select Patient...</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('patient_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- <!-- Doctor Department (Display only) -->
                            <div class="col-md-3">
                                <div class="mt-3">
                                    <label class="form-label">Doctor's Department</label>
                                    <input type="text" id="department" class="form-control" readonly>
                                </div>
                            </div>

                            <!-- Doctor Specialization (Display only) -->
                            <div class="col-md-3">
                                <div class="mt-3">
                                    <label class="form-label">Doctor's Specialization</label>
                                    <input type="text" id="specialization" class="form-control" readonly>
                                </div>
                            </div> --}}
                        </div>

                        <div class="row mt-4">
                            <!-- Appointment Date -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label">Appointment Date</label>
                                    <input type="date"
                                        class="form-control @error('appointment_date') is-invalid @enderror"
                                        name="appointment_date" id="appointment_date" required>
                                    @error('appointment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Appointment Time -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="appointment_time" class="form-label">Appointment Time</label>
                                    <input type="time"
                                        class="form-control @error('appointment_time') is-invalid @enderror"
                                        name="appointment_time" id="appointment_time" required>
                                    @error('appointment_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="status1" class="form-label">Status</label>
                                    <select id="status1"
                                        class="form-control select2 @error('status') is-invalid @enderror" name="status">
                                        <option selected disabled value="">Choose...</option>
                                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                        <option value="Next Appointment"
                                            {{ old('status') == 'Next Appointment' ? 'selected' : '' }}>
                                            Next Appointment</option>
                                        {{-- 'pending', 'confirmed', 'completed', 'cancelled', 'schedule next appointment' --}}
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes (Optional)</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="1"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mt-3 mb-3">
                            <a href="{{ route('admin.appointment.index') }}" class="btn btn-outline-danger">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-secondary w-md">Submit</button>
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
