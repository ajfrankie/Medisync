@extends('backend.layouts.master')

@section('title')
    Edit Doctor
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Doctors
        @endslot
        @slot('title')
            Edit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('admin.doctor.update', $doctor->id) }}">
                        @csrf
                        @method('PUT')

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        <div class="row">

                            <!-- Doctor's Name (Read Only) -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Doctor's Name</label>
                                    <input type="text" class="form-control" value="{{ $doctor->user->name }}" readonly>
                                    <input type="hidden" name="user_id" value="{{ $doctor->user_id }}">
                                </div>
                            </div>

                            <!-- Specialization -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="specialization" class="form-label">Doctor's Specialization</label>
                                    <select id="specialization"
                                        class="form-control select2 @error('specialization') is-invalid @enderror"
                                        name="specialization">
                                        <option value="">Choose...</option>
                                        @foreach ([
                                            'General Medicine', 'Cardiology', 'Neurology', 'Oncology', 'Orthopedics',
                                            'Pediatrics', 'OB/GYN', 'Surgery', 'Radiology', 'Pathology', 'Gastroenterology',
                                            'Pulmonology', 'Nephrology', 'Endocrinology', 'Dermatology', 'Psychiatry',
                                            'Ophthalmology', 'ENT', 'Physical Therapy', 'Pharmacy', 'Urology', 'Hospice Care'
                                        ] as $specialty)
                                            <option value="{{ $specialty }}"
                                                {{ $doctor->specialization == $specialty ? 'selected' : '' }}>
                                                {{ $specialty }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specialization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Doctor's Department</label>
                                    <select id="department"
                                        class="form-control select2 @error('department') is-invalid @enderror"
                                        name="department">
                                        <option value="">Choose...</option>
                                        @foreach ([
                                            'Emergency', 'ICU', 'Cardiology', 'Neurology', 'Oncology', 'Orthopedics', 
                                            'Pediatrics', 'OB/GYN', 'Surgery', 'Radiology', 'Pathology/Laboratory',
                                            'Gastroenterology', 'Pulmonology', 'Nephrology', 'Endocrinology', 'Dermatology',
                                            'Psychiatry/MentalHealth', 'Ophthalmology', 'ENT', 
                                            'Physical Therapy/Rehabilitation', 'Pharmacy', 'Urology', 'HospiceCare'
                                        ] as $dept)
                                            <option value="{{ $dept }}"
                                                {{ $doctor->department == $dept ? 'selected' : '' }}>
                                                {{ $dept }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Experience -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="experience" class="form-label">Doctor's Experience (years)</label>
                                    <input type="number" class="form-control @error('experience') is-invalid @enderror"
                                        name="experience" id="experience" placeholder="Enter experience"
                                        value="{{ old('experience', $doctor->experience) }}">
                                    @error('experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-danger">Cancel</a>
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
    <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>
@endsection
