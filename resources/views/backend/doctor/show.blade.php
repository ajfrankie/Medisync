@extends('backend.layouts.master')

@section('title')
    Doctor Details
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Doctors
        @endslot
        @slot('title')
            Details
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <!-- Doctor Name -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Doctor's Name</label>
                                <input type="text" class="form-control" value="{{ $doctor->user->name ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $doctor->user->email ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" value="{{ $doctor->user->phone ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <!-- Specialization -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Specialization</label>
                                <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $doctor->specialization)) ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <!-- Department -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $doctor->department)) ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <!-- Experience -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Experience (years)</label>
                                <input type="text" class="form-control" value="{{ $doctor->experience ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{ $doctor->is_activated ? 'Available' : 'Not Available' }}" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="text-end pe-3 mb-3">
                        <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-secondary w-md">
                            Back
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
