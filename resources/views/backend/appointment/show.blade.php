@extends('backend.layouts.master')

@section('title')
    Appointment Details
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Appointment
        @endslot
        @slot('title')
            Details
        @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-semibold text-dark mb-0">
                            Appointment Information
                        </h4>
                        <a href="{{ route('admin.appointment.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back
                        </a>
                    </div>

                    <!-- Appointment Info -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Appointment Date</h6>
                            <p class="fw-semibold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Appointment Time</h6>
                            <p class="fw-semibold">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Status</h6>
                            <span
                                class="badge 
                                @if ($appointment->status == 'Pending') bg-warning 
                                @elseif($appointment->status == 'Confirmed') bg-info 
                                @elseif($appointment->status == 'Completed') bg-success 
                                @elseif($appointment->status == 'Cancelled') bg-danger 
                                @else bg-secondary @endif
                                p-2">{{ $appointment->status ?? 'N/A' }}</span>
                        </div>
                    </div>

                    @if ($appointment->next_appointment_date)
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h6 class="text-muted mb-1">Next Appointment Date</h6>
                                <p class="fw-semibold text-primary">{{ \Carbon\Carbon::parse($appointment->next_appointment_date)->format('F d, Y') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Doctor Info -->
                    <h5 class="fw-bold text-dark border-bottom pb-2 mt-4">Doctor Details</h5>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Name</h6>
                            <p class="fw-semibold">{{ $appointment->doctor->user->name }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Department</h6>
                            <p class="fw-semibold">{{ $appointment->doctor->department }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Specialization</h6>
                            <p class="fw-semibold">{{ $appointment->doctor->specialization }}</p>
                        </div>
                    </div>

                    <!-- Patient Info -->
                    <h5 class="fw-bold text-dark border-bottom pb-2 mt-4">Patient Details</h5>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <h6 class="text-muted mb-1">Name</h6>
                            <p class="fw-semibold">{{ $appointment->patient->user->name }}</p>
                        </div>
                        @if (!empty($appointment->patient->user->email))
                            <div class="col-md-4">
                                <h6 class="text-muted mb-1">Email</h6>
                                <p class="fw-semibold">{{ $appointment->patient->user->email }}</p>
                            </div>
                        @endif
                        @if (!empty($appointment->patient->user->phone))
                            <div class="col-md-4">
                                <h6 class="text-muted mb-1">Phone</h6>
                                <p class="fw-semibold">{{ $appointment->patient->user->phone }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Notes -->
                    @if (!empty($appointment->notes))
                        <div class="mt-4">
                            <h5 class="fw-bold text-dark border-bottom pb-2">Notes</h5>
                            <p class="mt-2 text-muted">{{ $appointment->notes }}</p>
                        </div>
                    @endif

                    <!-- Footer Buttons -->
                    <div class="text-end mt-4 d-flex flex-wrap justify-content-end gap-2">
                        <a href="{{ route('admin.appointment.index') }}" class="btn btn-outline-danger">
                            Cancel
                        </a>
                        <a href="{{ route('admin.appointment.edit', $appointment->id) }}" class="btn btn-outline-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('admin.doctor.show', $appointment->doctor->id) }}" class="btn btn-outline-info">
                            <i class="mdi mdi-eye"></i> View Doctor Details
                        </a>
                        <a href="{{ route('admin.patient.show', $appointment->patient->id) }}" class="btn btn-outline-success">
                            <i class="mdi mdi-eye"></i> View Patient Details
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
