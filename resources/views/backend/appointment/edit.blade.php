@extends('backend.layouts.master')

@section('title')
    Appointment Edit
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
            Appointment
        @endslot
        @slot('title')
            Edit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('admin.appointment.update', $appointment->id) }}">
                        @csrf
                        @method('PUT')

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        <div class="row">
                            <!-- Doctor -->
                            <div class="col-xl-4">
                                <div class="mt-3">
                                    <label class="form-label">Doctor's Name</label>
                                    <select class="form-select select2 @error('doctor_id') is-invalid @enderror"
                                        id="doctor_id" name="doctor_id">
                                        <option value="">Select Doctor...</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Doctor Department -->
                            <div class="col-md-4">
                                <div class="mt-3">
                                    <label class="form-label">Doctor's Department</label>
                                    <input type="text" id="department" class="form-control" readonly>
                                </div>
                            </div>

                            <!-- Doctor Specialization -->
                            <div class="col-md-4">
                                <div class="mt-3">
                                    <label class="form-label">Doctor's Specialization</label>
                                    <input type="text" id="specialization" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">

                            <!-- Patient -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Patient's Name</label>
                                    <select class="form-select select2 @error('patient_id') is-invalid @enderror"
                                        id="patient_id" name="patient_id">
                                        <option value="">Select Patient...</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('patient_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Appointment Date -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label">Appointment Date</label>
                                    <input type="date"
                                        class="form-control @error('appointment_date') is-invalid @enderror"
                                        name="appointment_date" id="appointment_date"
                                        value="{{ $appointment->appointment_date }}">
                                    @error('appointment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- <!-- Appointment Time -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="appointment_time" class="form-label">Appointment Time</label>
                                    <input type="time"
                                        class="form-control @error('appointment_time') is-invalid @enderror"
                                        name="appointment_time" id="appointment_time"
                                        value="{{ $appointment->appointment_time }}">
                                    @error('appointment_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="appointment_time" class="form-label">Appointment Time</label>
                                    <input type="time"
                                        class="form-control @error('appointment_time') is-invalid @enderror"
                                        name="appointment_time" id="appointment_time"
                                        value="{{ $appointment->appointment_time }}">
                                    @error('appointment_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Appointment Time -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="next_appointment_date" class="form-label">Next Appointment Date</label>
                                    <input type="date"
                                        class="form-control @error('next_appointment_date') is-invalid @enderror"
                                        name="next_appointment_date" id="next_appointment_date"
                                        value="{{ $appointment->next_appointment_date }}">
                                    @error('next_appointment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        <div class="row mt-4">
                            <!-- Notes -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status1" class="form-label">Status</label>
                                    <select id="status1"
                                        class="form-control select2 @error('status') is-invalid @enderror" name="status">
                                        <option selected disabled value="">Choose...</option>
                                        <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Confirmed"
                                            {{ $appointment->status == 'Confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="Completed"
                                            {{ $appointment->status == 'Completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="Cancelled"
                                            {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                        <option value="Next Appointment"
                                            {{ $appointment->status == 'Next Appointment' ? 'selected' : '' }}>
                                            Next Appointment</option>
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes (Optional)</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="2">{{ $appointment->notes }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mt-3 mb-3">
                            <a href="{{ route('admin.appointment.index') }}" class="btn btn-outline-danger">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-outline-secondary w-md">Update</button>
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

    <script>
        $(document).ready(function() {
            // Function to fetch doctor details
            function fetchDoctorDetails(doctorId) {
                if (doctorId) {
                    $.ajax({
                        url: "{{ route('admin.appointment.getDoctorDetails') }}",
                        type: "GET",
                        data: {
                            doctor_id: doctorId
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#department').val(response.department);
                                $('#specialization').val(response.specialization);
                            } else {
                                $('#department').val('');
                                $('#specialization').val('');
                            }
                        },
                        error: function() {
                            alert('Unable to fetch doctor details.');
                        }
                    });
                } else {
                    $('#department').val('');
                    $('#specialization').val('');
                }
            }

            // Fetch when page loads (for already selected doctor)
            const selectedDoctor = $('#doctor_id').val();
            fetchDoctorDetails(selectedDoctor);

            // Fetch when doctor changes
            $('#doctor_id').on('change', function() {
                fetchDoctorDetails($(this).val());
            });
        });
    </script>
    <script>
        flatpickr("#appointment_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i", // 24-hour format (HH:MM)
            time_24hr: true, // ensures 24-hour time
            minTime: "09:00",
            maxTime: "18:00",
            minuteIncrement: 30
        });
    </script>
@endsection
