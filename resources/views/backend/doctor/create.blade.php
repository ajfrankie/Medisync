@extends('backend.layouts.master')

@section('title')
    Doctors Create
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Doctors
        @endslot
        @slot('title')
            Create
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{!! route('admin.doctor.store') !!}">
                        @csrf
<input type="hidden" name="role" value="doctor">
                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">

                            <!-- Doctor Name -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Doctor's Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" placeholder="Enter name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" placeholder="Enter email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Enter password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" id="phone" placeholder="Enter phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <!-- Specialization -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="specialization" class="form-label">Doctor's Specialization</label>
                                    <select id="specialization"
                                        class="form-control select2 @error('specialization') is-invalid @enderror"
                                        name="specialization">
                                        <option selected disabled value="">Choose...</option>
                                        <option value="general_medicine"
                                            {{ old('specialization') == 'general_medicine' ? 'selected' : '' }}>General
                                            Medicine</option>
                                        <option value="cardiology"
                                            {{ old('specialization') == 'cardiology' ? 'selected' : '' }}>Cardiology
                                        </option>
                                        <option value="neurology"
                                            {{ old('specialization') == 'neurology' ? 'selected' : '' }}>Neurology</option>
                                        <option value="oncology"
                                            {{ old('specialization') == 'oncology' ? 'selected' : '' }}>Oncology</option>
                                        <option value="orthopedics"
                                            {{ old('specialization') == 'orthopedics' ? 'selected' : '' }}>Orthopedics
                                        </option>
                                        <option value="pediatrics"
                                            {{ old('specialization') == 'pediatrics' ? 'selected' : '' }}>Pediatrics
                                        </option>
                                        <option value="obgyn" {{ old('specialization') == 'obgyn' ? 'selected' : '' }}>
                                            OB/GYN</option>
                                        <option value="surgery" {{ old('specialization') == 'surgery' ? 'selected' : '' }}>
                                            Surgery</option>
                                        <option value="radiology"
                                            {{ old('specialization') == 'radiology' ? 'selected' : '' }}>Radiology</option>
                                        <option value="pathology"
                                            {{ old('specialization') == 'pathology' ? 'selected' : '' }}>Pathology /
                                            Laboratory</option>
                                        <option value="gastroenterology"
                                            {{ old('specialization') == 'gastroenterology' ? 'selected' : '' }}>
                                            Gastroenterology</option>
                                        <option value="pulmonology"
                                            {{ old('specialization') == 'pulmonology' ? 'selected' : '' }}>Pulmonology
                                        </option>
                                        <option value="nephrology"
                                            {{ old('specialization') == 'nephrology' ? 'selected' : '' }}>Nephrology
                                        </option>
                                        <option value="endocrinology"
                                            {{ old('specialization') == 'endocrinology' ? 'selected' : '' }}>Endocrinology
                                        </option>
                                        <option value="dermatology"
                                            {{ old('specialization') == 'dermatology' ? 'selected' : '' }}>Dermatology
                                        </option>
                                        <option value="psychiatry"
                                            {{ old('specialization') == 'psychiatry' ? 'selected' : '' }}>Psychiatry /
                                            Mental Health</option>
                                        <option value="ophthalmology"
                                            {{ old('specialization') == 'ophthalmology' ? 'selected' : '' }}>Ophthalmology
                                        </option>
                                        <option value="ent" {{ old('specialization') == 'ent' ? 'selected' : '' }}>ENT
                                        </option>
                                        <option value="rehabilitation"
                                            {{ old('specialization') == 'rehabilitation' ? 'selected' : '' }}>Physical
                                            Therapy / Rehabilitation</option>
                                        <option value="pharmacy"
                                            {{ old('specialization') == 'pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                                        <option value="urology" {{ old('specialization') == 'urology' ? 'selected' : '' }}>
                                            Urology</option>
                                        <option value="palliative"
                                            {{ old('specialization') == 'palliative' ? 'selected' : '' }}>Palliative /
                                            Hospice Care</option>
                                    </select>
                                    @error('specialization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Doctor's Department</label>
                                    <select id="department"
                                        class="form-control select2 @error('department') is-invalid @enderror"
                                        name="department">
                                        <option selected disabled value="">Choose...</option>
                                        <option value="emergency" {{ old('department') == 'emergency' ? 'selected' : '' }}>
                                            ED / ER</option>
                                        <option value="icu" {{ old('department') == 'icu' ? 'selected' : '' }}>ICU
                                        </option>
                                        <option value="cardiology"
                                            {{ old('department') == 'cardiology' ? 'selected' : '' }}>Cardiology</option>
                                        <option value="neurology" {{ old('department') == 'neurology' ? 'selected' : '' }}>
                                            Neurology</option>
                                        <option value="oncology" {{ old('department') == 'oncology' ? 'selected' : '' }}>
                                            Oncology</option>
                                        <option value="orthopedics"
                                            {{ old('department') == 'orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                                        <option value="pediatrics"
                                            {{ old('department') == 'pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                                        <option value="obgyn" {{ old('department') == 'obgyn' ? 'selected' : '' }}>OB/GYN
                                        </option>
                                        <option value="surgery" {{ old('department') == 'surgery' ? 'selected' : '' }}>
                                            Surgery</option>
                                        <option value="radiology"
                                            {{ old('department') == 'radiology' ? 'selected' : '' }}>Radiology</option>
                                        <option value="pathology"
                                            {{ old('department') == 'pathology' ? 'selected' : '' }}>Pathology / Laboratory
                                        </option>
                                        <option value="gastroenterology"
                                            {{ old('department') == 'gastroenterology' ? 'selected' : '' }}>
                                            Gastroenterology</option>
                                        <option value="pulmonology"
                                            {{ old('department') == 'pulmonology' ? 'selected' : '' }}>Pulmonology</option>
                                        <option value="nephrology"
                                            {{ old('department') == 'nephrology' ? 'selected' : '' }}>Nephrology</option>
                                        <option value="endocrinology"
                                            {{ old('department') == 'endocrinology' ? 'selected' : '' }}>Endocrinology
                                        </option>
                                        <option value="dermatology"
                                            {{ old('department') == 'dermatology' ? 'selected' : '' }}>Dermatology</option>
                                        <option value="psychiatry"
                                            {{ old('department') == 'psychiatry' ? 'selected' : '' }}>Psychiatry / Mental
                                            Health</option>
                                        <option value="ophthalmology"
                                            {{ old('department') == 'ophthalmology' ? 'selected' : '' }}>Ophthalmology
                                        </option>
                                        <option value="ent" {{ old('department') == 'ent' ? 'selected' : '' }}>ENT
                                        </option>
                                        <option value="rehabilitation"
                                            {{ old('department') == 'rehabilitation' ? 'selected' : '' }}>Physical Therapy
                                            / Rehabilitation</option>
                                        <option value="pharmacy" {{ old('department') == 'pharmacy' ? 'selected' : '' }}>
                                            Pharmacy</option>
                                        <option value="urology" {{ old('department') == 'urology' ? 'selected' : '' }}>
                                            Urology</option>
                                        <option value="palliative"
                                            {{ old('department') == 'palliative' ? 'selected' : '' }}>Palliative / Hospice
                                            Care</option>
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Experience -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="experience" class="form-label">Doctor's Experience (years)</label>
                                    <input type="number" class="form-control @error('experience') is-invalid @enderror"
                                        name="experience" id="experience" placeholder="Enter experience"
                                        value="{{ old('experience') }}">
                                    @error('experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-danger custom-cancel-btn">
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

@section('scripts')
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>
@endsection
