

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
                        <form method="GET" action="{{ route('admin.appointment.index') }}">
                            <div class="row g-3">

                                <!-- Filter by Doctor -->
                                <div class="col-md-3">
                                    <label class="form-label">Doctor's Name</label>
                                    <select class="form-select select2" name="doctor_id">
                                        <option value="">All Doctors</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter by Patient -->
                                <div class="col-md-3">
                                    <label class="form-label">Patient's Name</label>
                                    <select class="form-select select2" name="patient_id">
                                        <option value="">All Patients</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter by Date -->
                                <div class="col-md-3">
                                    <label class="form-label">Appointment Date</label>
                                    <input type="date" name="appointment_date" class="form-control"
                                        value="{{ request('appointment_date') }}">
                                </div>

                                <!-- Filter by Status -->
                                <div class="col-md-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="">All Statuses</option>
                                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="Next Appointment" {{ request('status') == 'Next Appointment' ? 'selected' : '' }}>Next Appointment</option>
                                    </select>
                                </div>

                                <!-- Filter Buttons -->
                                <div class="col-xl-12 mt-3 d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-outline-secondary w-md">
                                        <i class="fa fa-search me-1"></i> Search
                                    </button>
                                    <a href="{{ route('admin.appointment.index') }}" class="btn btn-light w-md">
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
