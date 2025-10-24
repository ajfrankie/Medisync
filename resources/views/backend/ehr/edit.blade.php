@extends('backend.layouts.master')

@section('title')
    Edit EHR Record
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            EHR Record
        @endslot
        @slot('title')
            Edit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Edit form -->
                    <form method="POST" action="{{ route('admin.ehr.update', $ehr->id) }}">
                        @csrf
                        @method('PUT') <!-- Important for update -->

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif
                        <!-- Doctor Name (readonly) + hidden ID -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Doctor</label>
                                    <input type="text" class="form-control"
                                        value="{{ $ehr->doctor->user->name ?? (auth()->user()->name ?? 'N/A') }}" readonly>
                                    <input type="hidden" name="doctor_id"
                                        value="{{ $ehr->doctor_id ?? (auth()->user()->doctor->id ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Patient</label>
                                    <input type="text" class="form-control"
                                        value="{{ $ehr->patient->user->name ?? (auth()->user()->name ?? 'N/A') }}" readonly>
                                    <input type="hidden" name="patient_id"
                                        value="{{ $ehr->patient_id ?? (auth()->user()->patient->id ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Flash Messages -->


                        <!-- Patient + Dates -->
                        <div class="row mt-4">
                            <!-- Patient Select -->

                            <!-- Visit Date -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="visit_date" class="form-label">Visit Date</label>
                                    <input type="date" class="form-control @error('visit_date') is-invalid @enderror"
                                        name="visit_date"
                                        value="{{ old('visit_date', $ehr->visit_date ? \Carbon\Carbon::parse($ehr->visit_date)->format('Y-m-d') : '') }}">
                                    @error('visit_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Next Visit Date -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="next_visit_date" class="form-label">Next Visit Date</label>
                                    <input type="date"
                                        class="form-control @error('next_visit_date') is-invalid @enderror"
                                        name="next_visit_date"
                                        value="{{ old('next_visit_date', $ehr->next_visit_date ? \Carbon\Carbon::parse($ehr->next_visit_date)->format('Y-m-d') : '') }}">
                                    @error('next_visit_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Diagnosis -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="diagnosis" class="form-label">Diagnosis</label>
                                    <textarea name="diagnosis" id="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3">{{ old('diagnosis', $ehr->diagnosis) }}</textarea>
                                    @error('diagnosis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Treatment Summary -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="treatment_summary" class="form-label">Treatment Summary</label>
                                    <textarea name="treatment_summary" id="treatment_summary"
                                        class="form-control @error('treatment_summary') is-invalid @enderror" rows="3">{{ old('treatment_summary', $ehr->treatment_summary) }}</textarea>
                                    @error('treatment_summary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div class="text-end pe-3 mt-3 mb-3">
                            <a href="{{ route('admin.patient.show', $ehr->patient_id) }}"
                                class="btn btn-outline-danger">Cancel</a>
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

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true
            });
        });
    </script>
@endsection
