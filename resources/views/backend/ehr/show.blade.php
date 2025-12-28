@extends('backend.layouts.master')

@section('title')
    EHR Record Details
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            EHR Record
        @endslot
        @slot('title')
            Details
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-info text-dark d-flex align-items-center">
                    <i class="ri-file-list-3-line me-2 fs-5"></i>
                    <span class="fw-semibold">EHR Details</span>
                </div>

                <div class="card-body">

                    <!-- Doctor & Patient Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Doctor</label>
                            <p class="form-control-plaintext">{{ $ehr->doctor->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Patient</label>
                            <p class="form-control-plaintext">{{ $ehr->patient->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Visit Dates -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Visit Date</label>
                            <p class="form-control-plaintext">
                                {{ \Carbon\Carbon::parse($ehr->visit_date)->format('d M Y') ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Next Visit Date</label>
                            <p class="form-control-plaintext">
                                {{ $ehr->next_visit_date ? \Carbon\Carbon::parse($ehr->next_visit_date)->format('d M Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <!-- Diagnosis -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Diagnosis</label>
                            <div class="p-3 border rounded bg-light">
                                {!! nl2br(e($ehr->diagnosis)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Treatment Summary -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Treatment Summary</label>
                            <div class="p-3 border rounded bg-light">
                                {!! nl2br(e($ehr->treatment_summary)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="text-end mt-4">
                        <a href="{{ route('admin.patient.show', $ehr->patient->id) }}" class="btn btn-outline-secondary">
                            <i class="ri-arrow-left-line me-1"></i> Back to Patient
                        </a>
                        @php
                            $user = auth()->user();
                        @endphp
                        @if ($user->role->role_name == 'Doctor')
                            <a href="{{ route('admin.ehr.edit', $ehr->id) }}" class="btn btn-outline-primary">
                                <i class="ri-edit-line me-1"></i> Edit EHR
                            </a>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endsection
