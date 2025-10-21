@extends('backend.layouts.master')

@section('title')
    Nurse Details
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Nurse
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
                        <!-- Nurse Name -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nurse's Name</label>
                                <input type="text" class="form-control" value="{{ $nurse->user->name ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $nurse->user->email ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" value="{{ $nurse->user->phone ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label><br>
                                @if ($nurse->is_activated)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Shift Time -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="shift_time" class="form-label">Shift Time</label>
                                <input type="text" class="form-control" value="{{ $nurse->shift_time ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <!-- Department -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" value="{{ ucfirst($nurse->department ?? 'N/A') }}" readonly>
                            </div>
                        </div>

                        <!-- Created Date -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Created On</label>
                                <input type="text" class="form-control" value="{{ $nurse->created_at->format('d M, Y') }}" readonly>
                            </div>
                        </div>

                        <!-- Last Updated -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Last Updated</label>
                                <input type="text" class="form-control" value="{{ $nurse->updated_at->format('d M, Y') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="text-end pe-3 mb-3">
                        <a href="{{ route('admin.nurse.index') }}" class="btn btn-outline-secondary">Back</a>
                        <a href="{{ route('admin.nurse.edit', $nurse->id) }}" class="btn btn-outline-primary">Edit</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
