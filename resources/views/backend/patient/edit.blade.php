@extends('backend.layouts.master')

@section('title')
    Edit Patient
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Patient
        @endslot
        @slot('title')
            Edit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.patient.update', $patient->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="role" value="Patient">

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        {{-- Patient Name (Non-editable) --}}
                       
                                <div class="mb-3">
                                    <label for="name" class="form-label">Patient's Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name', $patient->user->name) }}"
                                        placeholder="Enter name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                        {{-- Blood Group, Marital Status, Preferred Language, Occupation --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Blood Group</label>
                                    <select name="blood_group"
                                        class="form-control @error('blood_group') is-invalid @enderror">
                                        <option value="" disabled selected>Choose...</option>
                                        @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                            <option value="{{ $group }}"
                                                {{ $patient->blood_group == $group ? 'selected' : '' }}>{{ $group }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('blood_group')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Marital Status</label>
                                    <select name="marital_status"
                                        class="form-control @error('marital_status') is-invalid @enderror">
                                        <option value="" disabled selected>Choose...</option>
                                        @foreach (['Single', 'Married', 'Divorced', 'Widowed'] as $status)
                                            <option value="{{ $status }}"
                                                {{ $patient->marital_status == $status ? 'selected' : '' }}>
                                                {{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('marital_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Preferred Language</label>
                                    <select name="preferred_language"
                                        class="form-control @error('preferred_language') is-invalid @enderror">
                                        <option value="" disabled selected>Choose...</option>
                                        @foreach (['Tamil', 'Sinhala', 'English'] as $lang)
                                            <option value="{{ $lang }}"
                                                {{ $patient->preferred_language == $lang ? 'selected' : '' }}>
                                                {{ $lang }}</option>
                                        @endforeach
                                    </select>
                                    @error('preferred_language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Occupation</label>
                                    <input type="text" name="occupation"
                                        class="form-control @error('occupation') is-invalid @enderror"
                                        value="{{ $patient->occupation }}" placeholder="Enter occupation">
                                    @error('occupation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Height & Weight --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Height (cm)</label>
                                    <input type="text" name="height"
                                        class="form-control @error('height') is-invalid @enderror"
                                        value="{{ $patient->height }}" placeholder="Enter height in cm">
                                    @error('height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="text" name="weight"
                                        class="form-control @error('weight') is-invalid @enderror"
                                        value="{{ $patient->weight }}" placeholder="Enter weight in kg">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Past Surgeries --}}
                        <h5 class="mt-4 mb-3">Past Surgeries</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Past Surgeries</label>
                                    <select name="past_surgeries" id="past_surgeries"
                                        class="form-control @error('past_surgeries') is-invalid @enderror">
                                        <option value="" disabled selected>Choose...</option>
                                        <option value="Yes" {{ $patient->past_surgeries == 'Yes' ? 'selected' : '' }}>
                                            Yes</option>
                                        <option value="No" {{ $patient->past_surgeries == 'No' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                    @error('past_surgeries')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Surgery Details</label>
                                    <input type="text" name="past_surgeries_details" id="past_surgeries_details"
                                        class="form-control @error('past_surgeries_details') is-invalid @enderror"
                                        value="{{ $patient->past_surgeries_details }}"
                                        placeholder="Enter past surgery details if any">
                                    @error('past_surgeries_details')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Emergency Contact --}}
                        <h5 class="mt-4 mb-3">Emergency Contact</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" name="emergency_person"
                                        class="form-control @error('emergency_person') is-invalid @enderror"
                                        value="{{ $patient->emergency_person }}" placeholder="Enter name">
                                    @error('emergency_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Relationship</label>
                                    <select name="emergency_relationship"
                                        class="form-control @error('emergency_relationship') is-invalid @enderror">
                                        <option value="" disabled selected>Choose...</option>
                                        @foreach (['Father', 'Mother', 'Sibling', 'Spouse', 'Friend'] as $relation)
                                            <option value="{{ $relation }}"
                                                {{ $patient->emergency_relationship == $relation ? 'selected' : '' }}>
                                                {{ $relation }}</option>
                                        @endforeach
                                    </select>
                                    @error('emergency_relationship')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Emergency Contact Number</label>
                                    <input type="text" name="emergency_contact"
                                        class="form-control @error('emergency_contact') is-invalid @enderror"
                                        value="{{ $patient->emergency_contact }}" placeholder="+947XXXXXXXX">
                                    @error('emergency_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="text-end">
                            <a href="{{ route('admin.patient.index') }}" class="btn btn-outline-danger">Cancel</a>
                            <button type="submit" class="btn btn-outline-secondary">Update</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Patient",
                allowClear: true
            });
        });
    </script>
@endsection
