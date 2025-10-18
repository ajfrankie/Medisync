@extends('backend.layouts.master')

@section('title')
    Edit Patient
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
                    {{-- enctype added for image upload --}}
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('admin.patient.update', $patient->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        {{-- BASIC INFORMATION --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Patient Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $patient->user->name ?? '') }}"
                                        placeholder="Enter patient's name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- EMAIL (READ-ONLY) --}}
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email (Cannot be changed)</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ $patient->user->email ?? '' }}" readonly>
                                </div>
                            </div>

                            {{-- PASSWORD (OPTIONAL CHANGE) --}}
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password (Leave blank to keep same)</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter new password if needed">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- PHONE --}}
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $patient->user->phone ?? '') }}"
                                        placeholder="Enter phone number">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- PERSONAL INFO --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" id="dob"
                                        class="form-control @error('dob') is-invalid @enderror"
                                        value="{{ old('dob', $patient->dob ?? ($patient->user->dob ?? '')) }}">
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="nic" class="form-label">NIC</label>
                                    <input type="text" name="nic" id="nic"
                                        class="form-control @error('nic') is-invalid @enderror"
                                        value="{{ old('nic', $patient->user->nic ?? '') }}" placeholder="Enter NIC number">
                                    @error('nic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender"
                                        class="form-control @error('gender') is-invalid @enderror">
                                        <option value="" disabled>Choose...</option>
                                        <option value="male"
                                            {{ old('gender', $patient->gender ?? '') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female"
                                            {{ old('gender', $patient->gender ?? '') == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="blood_group" class="form-label">Blood Group</label>
                                    <select name="blood_group" id="blood_group"
                                        class="form-control @error('blood_group') is-invalid @enderror">
                                        <option value="" disabled>Choose...</option>
                                        @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                            <option value="{{ $group }}"
                                                {{ old('blood_group', $patient->blood_group ?? '') == $group ? 'selected' : '' }}>
                                                {{ $group }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('blood_group')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ADDRESS + IMAGE --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address', $patient->address ?? '') }}"
                                        placeholder="Enter address">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- IMAGE UPLOAD WITH PREVIEW --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image_path" class="form-label">Upload Image</label>
                                    <input type="file" name="image_path" id="image_path"
                                        class="form-control @error('image_path') is-invalid @enderror" accept="image/*">
                                    @if ($patient->user->image_path)
                                        <div class="mt-2">
                                            <p class="mb-1">Current Image:</p>
                                            <img src="{{ asset('storage/' . $patient->user->image_path) }}"
                                                alt="Patient Image" width="100" class="rounded shadow">
                                        </div>
                                    @endif
                                    @error('image_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- EMERGENCY CONTACT --}}
                        <h5 class="mt-4 mb-3">Emergency Contact</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="emergency_person" class="form-label">Contact Person</label>
                                    <input type="text" name="emergency_person" id="emergency_person"
                                        class="form-control @error('emergency_person') is-invalid @enderror"
                                        value="{{ old('emergency_person', $patient->emergency_person ?? '') }}"
                                        placeholder="Enter contact person name">
                                    @error('emergency_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="emergency_relationship" class="form-label">Relationship</label>
                                    <select name="emergency_relationship" id="emergency_relationship"
                                        class="form-control @error('emergency_relationship') is-invalid @enderror">
                                        <option value="" disabled>Choose...</option>
                                        @foreach (['Father', 'Mother', 'Sibling', 'Spouse', 'Friend'] as $relation)
                                            <option value="{{ $relation }}"
                                                {{ old('emergency_relationship', $patient->emergency_relationship ?? '') == $relation ? 'selected' : '' }}>
                                                {{ $relation }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('emergency_relationship')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="emergency_contact" class="form-label">Emergency Contact Number</label>
                                    <input type="text" name="emergency_contact" id="emergency_contact"
                                        class="form-control @error('emergency_contact') is-invalid @enderror"
                                        value="{{ old('emergency_contact', $patient->emergency_contact ?? '') }}"
                                        placeholder="Enter emergency phone number">
                                    @error('emergency_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.patient.index') }}" class="btn btn-outline-danger">Cancel</a>
                            <button type="submit" class="btn btn-secondary w-md">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
