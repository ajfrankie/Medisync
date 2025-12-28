@extends('backend.layouts.master')

@section('title')
    Appointments
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
            Appointments
        @endslot
        @slot('title')
            Appointments
        @endslot
    @endcomponent
    @include('backend.layouts.alert')


    @include('backend.appointment.filter')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">Appointments</h5>
                        <a href="{{ route('admin.appointment.create') }}" class="btn btn-outline-primary w-md">
                            <i class="fas fa-plus me-1"></i>
                            Create Appointment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Department</th>
                                    <th scope="col">Doctor's Name</th>
                                    <th scope="col">Pacient's Name</th>
                                    <th scope="col">Appointment Date</th>
                                    <th scope="col">Next Appointment</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->doctor->department ?? 'N/A' }}</td>
                                        <td>{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                                        <td>{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                                        <td>{{ $appointment->appointment_date ?? 'N/A' }}</td>
                                        <td>{{ $appointment->next_appointment_date ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'Pending' => 'warning',
                                                    'Confirmed' => 'info',
                                                    'Completed' => 'success',
                                                    'Cancelled' => 'danger',
                                                    'Next Appointment' => 'primary',
                                                ];
                                            @endphp
                                            <span
                                                class="badge bg-{{ $statusColors[$appointment->status] ?? 'secondary' }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group text-nowrap" role="group">
                                                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded fs-5" style="color:#898787"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.appointment.show', $appointment->id) }}">
                                                        <i class="bx bx-show"></i> Show
                                                    </a>
                                                    @php
                                                        $user = auth()->user();
                                                    @endphp
                                                    @if ($user->role->role_name == 'Doctor')
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.appointment.edit', $appointment->id) }}">
                                                            <i class="bx bx-edit-alt"></i> Edit
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <!-- end table -->
                    </div>
                    <!-- end table responsive -->
                </div>
                <!-- end card body -->
                <div class="text-end">
                    <ul class="pagination-rounded">
                        {{ $appointments->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
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
@endsection
