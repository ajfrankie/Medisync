@extends('backend.layouts.master')

@section('title')
    Create Patient
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Patient
        @endslot
        @slot('title')
            Create
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.patient.store') }}">
                        @csrf
                        <input type="hidden" name="role" value="Patient">

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        {{-- Basic Patient Information --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Patient Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        placeholder="Enter patient's name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Enter email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}" placeholder="Enter phone number">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Personal Information --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" id="dob"
                                        class="form-control @error('dob') is-invalid @enderror"
                                        value="{{ old('dob') }}">
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="nic" class="form-label">NIC</label>
                                    <input type="text" name="nic" id="nic"
                                        class="form-control @error('nic') is-invalid @enderror" value="{{ old('nic') }}"
                                        placeholder="Enter NIC number">
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
                                        <option value="" disabled selected>Choose...</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                        </option>
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
                                        <option value="" disabled selected>Choose...</option>
                                        @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                            <option value="{{ $group }}"
                                                {{ old('blood_group') == $group ? 'selected' : '' }}>
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

                        {{-- Address and Image --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address') }}" placeholder="Enter address">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image_path" class="form-label">Upload Image</label>
                                    <input type="file" name="image_path" id="image_path"
                                        class="form-control @error('image_path') is-invalid @enderror" accept="image/*">
                                    @error('image_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- Emergency Contact Info --}}
                        <h5 class="mt-4 mb-3">Emergency Contact</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="emergency_person" class="form-label">Contact Person</label>
                                    <input type="text" name="emergency_person" id="emergency_person"
                                        class="form-control @error('emergency_person') is-invalid @enderror"
                                        value="{{ old('emergency_person') }}" placeholder="Enter contact person name">
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
                                        <option value="" disabled selected>Choose...</option>
                                        @foreach (['Father', 'Mother', 'Sibling', 'Spouse', 'Friend'] as $relation)
                                            <option value="{{ $relation }}"
                                                {{ old('emergency_relationship') == $relation ? 'selected' : '' }}>
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
                                        value="{{ old('emergency_contact') }}"
                                        placeholder="Enter emergency phone number">
                                    @error('emergency_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Submit + Cancel --}}
                        <div class="text-end pe-3 mb-3">
                            <a href="{{ route('admin.patient.index') }}" class="btn btn-outline-danger">Cancel</a>
                            <button type="submit" class="btn btn-secondary w-md">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
