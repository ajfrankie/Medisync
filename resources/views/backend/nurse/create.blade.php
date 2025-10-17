@extends('backend.layouts.master')

@section('title')
    Nurse Edit
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Nurse
        @endslot
        @slot('title')
            Edit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.nurse.update', $nurse->id) }}">
                        @csrf
                        @method('PUT')

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

                            <!-- Nurse Name -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nurse's Name</label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           id="name"
                                           value="{{ old('name', $nurse->user->name ?? '') }}"
                                           placeholder="Enter name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email (non-editable) -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email (non-editable)</label>
                                    <input type="email"
                                           class="form-control"
                                           id="email"
                                           value="{{ $nurse->user->email ?? '' }}"
                                           readonly>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           name="phone"
                                           id="phone"
                                           value="{{ old('phone', $nurse->user->phone ?? '') }}"
                                           placeholder="Enter phone">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <!-- Shift Time -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="shift_time" class="form-label">Nurse's Shift Time</label>
                                    <select id="shift_time"
                                            class="form-control select2 @error('shift_time') is-invalid @enderror"
                                            name="shift_time">
                                        <option selected disabled value="">Choose...</option>
                                        <option value="Morning (6 AM - 2 PM)"
                                            {{ old('shift_time', $nurse->shift_time) == 'Morning (6 AM - 2 PM)' ? 'selected' : '' }}>
                                            Morning (6 AM - 2 PM)
                                        </option>
                                        <option value="Afternoon (2 PM - 10 PM)"
                                            {{ old('shift_time', $nurse->shift_time) == 'Afternoon (2 PM - 10 PM)' ? 'selected' : '' }}>
                                            Afternoon (2 PM - 10 PM)
                                        </option>
                                        <option value="Night (10 PM - 6 AM)"
                                            {{ old('shift_time', $nurse->shift_time) == 'Night (10 PM - 6 AM)' ? 'selected' : '' }}>
                                            Night (10 PM - 6 AM)
                                        </option>
                                    </select>
                                    @error('shift_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Nurse's Department</label>
                                    <select id="department"
                                            class="form-control select2 @error('department') is-invalid @enderror"
                                            name="department">
                                        <option selected disabled value="">Choose...</option>
                                        <option value="emergency" {{ old('department', $nurse->department) == 'emergency' ? 'selected' : '' }}>ED / ER</option>
                                        <option value="icu" {{ old('department', $nurse->department) == 'icu' ? 'selected' : '' }}>ICU</option>
                                        <option value="cardiology" {{ old('department', $nurse->department) == 'cardiology' ? 'selected' : '' }}>Cardiology</option>
                                        <option value="neurology" {{ old('department', $nurse->department) == 'neurology' ? 'selected' : '' }}>Neurology</option>
                                        <option value="oncology" {{ old('department', $nurse->department) == 'oncology' ? 'selected' : '' }}>Oncology</option>
                                        <option value="orthopedics" {{ old('department', $nurse->department) == 'orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                                        <option value="pediatrics" {{ old('department', $nurse->department) == 'pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                                        <option value="obgyn" {{ old('department', $nurse->department) == 'obgyn' ? 'selected' : '' }}>OB/GYN</option>
                                        <option value="surgery" {{ old('department', $nurse->department) == 'surgery' ? 'selected' : '' }}>Surgery</option>
                                        <option value="radiology" {{ old('department', $nurse->department) == 'radiology' ? 'selected' : '' }}>Radiology</option>
                                        <option value="pathology" {{ old('department', $nurse->department) == 'pathology' ? 'selected' : '' }}>Pathology / Laboratory</option>
                                        <option value="gastroenterology" {{ old('department', $nurse->department) == 'gastroenterology' ? 'selected' : '' }}>Gastroenterology</option>
                                        <option value="pulmonology" {{ old('department', $nurse->department) == 'pulmonology' ? 'selected' : '' }}>Pulmonology</option>
                                        <option value="nephrology" {{ old('department', $nurse->department) == 'nephrology' ? 'selected' : '' }}>Nephrology</option>
                                        <option value="endocrinology" {{ old('department', $nurse->department) == 'endocrinology' ? 'selected' : '' }}>Endocrinology</option>
                                        <option value="dermatology" {{ old('department', $nurse->department) == 'dermatology' ? 'selected' : '' }}>Dermatology</option>
                                        <option value="psychiatry" {{ old('department', $nurse->department) == 'psychiatry' ? 'selected' : '' }}>Psychiatry / Mental Health</option>
                                        <option value="ophthalmology" {{ old('department', $nurse->department) == 'ophthalmology' ? 'selected' : '' }}>Ophthalmology</option>
                                        <option value="ent" {{ old('department', $nurse->department) == 'ent' ? 'selected' : '' }}>ENT</option>
                                        <option value="rehabilitation" {{ old('department', $nurse->department) == 'rehabilitation' ? 'selected' : '' }}>Physical Therapy / Rehabilitation</option>
                                        <option value="pharmacy" {{ old('department', $nurse->department) == 'pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                                        <option value="urology" {{ old('department', $nurse->department) == 'urology' ? 'selected' : '' }}>Urology</option>
                                        <option value="palliative" {{ old('department', $nurse->department) == 'palliative' ? 'selected' : '' }}>Palliative / Hospice Care</option>
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.nurse.index') }}" class="btn btn-outline-danger custom-cancel-btn">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-secondary w-md">Update</button>
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
            $('.select2').select2({ width: '100%' });
        });
    </script>
@endsection
