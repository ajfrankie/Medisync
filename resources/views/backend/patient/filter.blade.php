<div class="row">
    <div class="mt-1 col-12">
        <div class="card accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFilter">
                    <button class="accordion-button fw-medium {{ request()->all() ? '' : 'collapsed' }}" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFilter"
                        aria-expanded="{{ request()->all() ? 'true' : 'false' }}" aria-controls="collapseFilter">
                        <span style="font-size: 14px;">
                            <i class="fa fa-filter me-1"></i> Filter
                        </span>
                    </button>
                </h2>

                <div id="collapseFilter" class="accordion-collapse collapse {{ request()->all() ? 'show' : '' }}"
                    aria-labelledby="headingFilter" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form method="GET" action="{{ route('admin.patient.index') }}">
                            <div class="row g-3">

                                <!-- Patient Name -->
                                <div class="col-md-3">
                                    <label class="form-label">Patient Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter name"
                                        value="{{ request('name') }}">
                                </div>

                                <!-- Email -->
                                <div class="col-md-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter email"
                                        value="{{ request('email') }}">
                                </div>

                                <!-- Phone -->
                                <div class="col-md-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Enter phone"
                                        value="{{ request('phone') }}">
                                </div>

                                <!-- NIC -->
                                <div class="col-md-3">
                                    <label class="form-label">NIC</label>
                                    <input type="text" name="nic" class="form-control" placeholder="Enter NIC"
                                        value="{{ request('nic') }}">
                                </div>

                                <!-- Gender -->
                                <div class="col-md-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" class="form-control select2" name="gender">
                                        <option value="">All</option>
                                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>

                                <!-- Blood Group -->
                                <div class="col-md-3">
                                    <label for="blood_group" class="form-label">Blood Group</label>
                                    <select id="blood_group" class="form-control select2" name="blood_group">
                                        <option value="">All</option>
                                        @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                            <option value="{{ $group }}"
                                                {{ request('blood_group') == $group ? 'selected' : '' }}>
                                                {{ $group }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- DOB -->
                                <div class="col-md-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" value="{{ request('dob') }}">
                                </div>

                                <!-- Emergency Contact -->
                                <div class="col-md-3">
                                    <label class="form-label">Emergency Contact</label>
                                    <input type="text" name="emergency_contact" class="form-control"
                                        placeholder="Enter contact number" value="{{ request('emergency_contact') }}">
                                </div>

                                <!-- Buttons -->
                                <div class="col-xl-12 mt-3 d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-outline-secondary w-md">
                                        <i class="fa fa-search me-1"></i> Search
                                    </button>
                                    <a href="{{ route('admin.patient.index') }}" class="btn btn-light w-md">
                                        <i class="fa fa-undo me-1"></i> Reset
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
