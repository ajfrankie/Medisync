@extends('backend.layouts.master-without-nav')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 600px; width: 100%;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">Create an Account</h3>
            <p class="text-muted">Please fill in the information below</p>
        </div>

        <form method="POST" action="{{ route('admin.register.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name">
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email">
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" name="dob" value="{{ old('dob') }}" class="form-control @error('dob') is-invalid @enderror">
                    @error('dob') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">NIC <span class="text-danger">*</span></label>
                    <input type="text" name="nic" value="{{ old('nic') }}" class="form-control @error('nic') is-invalid @enderror" placeholder="Enter NIC number">
                    @error('nic') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone number">
                    @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Select Role <span class="text-danger">*</span></label>
                    <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                        <option value="">Select a Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password">
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                </div>

                <div class="col-md-12">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="image_path" class="form-control @error('image_path') is-invalid @enderror" accept="image/*">
                    @error('image_path') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-4 d-grid">
                <button class="btn btn-primary w-100" type="submit">Register</button>
            </div>

            <div class="text-center mt-3">
                <p>Already have an account? <a href="{{ route('admin.login') }}" class="text-primary fw-bold">Login</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
