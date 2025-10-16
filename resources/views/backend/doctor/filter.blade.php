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
                        <form method="GET" action="{{ route('admin.doctor.index') }}">
                            <div class="row g-3">

                                <!-- Doctor Name -->
                                <div class="col-md-3">
                                    <label class="form-label">Doctor's Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter name"
                                        value="{{ request('name') }}">
                                </div>

                                <!-- Phone -->
                                <div class="col-md-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Enter phone"
                                        value="{{ request('phone') }}">
                                </div>

                                <!-- Department -->
                                <div class="col-md-3">
                                    <label class="form-label">Department</label>
                                    <select class="form-select" name="department">
                                        <option value="">All Departments</option>
                                        @foreach ($doctors->pluck('department')->unique() as $department)
                                            <option value="{{ $department }}"
                                                {{ request('department') == $department ? 'selected' : '' }}>
                                                {{ \Illuminate\Support\Str::of($department)->replace('_', ' ')->title() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Specialization -->
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="specialization" class="form-label">Doctor's Specialization</label>
                                        <select id="specialization"
                                            class="form-control select2 @error('specialization') is-invalid @enderror"
                                            name="specialization">
                                            <option value="">All Specializations</option>
                                            @php
                                                $specializations = [
                                                    'general_medicine' => 'General Medicine',
                                                    'cardiology' => 'Cardiology',
                                                    'neurology' => 'Neurology',
                                                    'oncology' => 'Oncology',
                                                    'orthopedics' => 'Orthopedics',
                                                    'pediatrics' => 'Pediatrics',
                                                    'obgyn' => 'OB/GYN',
                                                    'surgery' => 'Surgery',
                                                    'radiology' => 'Radiology',
                                                    'pathology' => 'Pathology / Laboratory',
                                                    'gastroenterology' => 'Gastroenterology',
                                                    'pulmonology' => 'Pulmonology',
                                                    'nephrology' => 'Nephrology',
                                                    'endocrinology' => 'Endocrinology',
                                                    'dermatology' => 'Dermatology',
                                                    'psychiatry' => 'Psychiatry / Mental Health',
                                                    'ophthalmology' => 'Ophthalmology',
                                                    'ent' => 'ENT',
                                                    'rehabilitation' => 'Physical Therapy / Rehabilitation',
                                                    'pharmacy' => 'Pharmacy',
                                                    'urology' => 'Urology',
                                                    'palliative' => 'Palliative / Hospice Care',
                                                ];
                                            @endphp
                                            @foreach ($specializations as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ request('specialization') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
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
                                            <option value="">All Departments</option>
                                            @php
                                                $departments = [
                                                    'emergency' => 'ED / ER',
                                                    'icu' => 'ICU',
                                                    'cardiology' => 'Cardiology',
                                                    'neurology' => 'Neurology',
                                                    'oncology' => 'Oncology',
                                                    'orthopedics' => 'Orthopedics',
                                                    'pediatrics' => 'Pediatrics',
                                                    'obgyn' => 'OB/GYN',
                                                    'surgery' => 'Surgery',
                                                    'radiology' => 'Radiology',
                                                    'pathology' => 'Pathology / Laboratory',
                                                    'gastroenterology' => 'Gastroenterology',
                                                    'pulmonology' => 'Pulmonology',
                                                    'nephrology' => 'Nephrology',
                                                    'endocrinology' => 'Endocrinology',
                                                    'dermatology' => 'Dermatology',
                                                    'psychiatry' => 'Psychiatry / Mental Health',
                                                    'ophthalmology' => 'Ophthalmology',
                                                    'ent' => 'ENT',
                                                    'rehabilitation' => 'Physical Therapy / Rehabilitation',
                                                    'pharmacy' => 'Pharmacy',
                                                    'urology' => 'Urology',
                                                    'palliative' => 'Palliative / Hospice Care',
                                                ];
                                            @endphp
                                            @foreach ($departments as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ request('department') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="col-xl-12 mt-3 d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-secondary w-md">
                                        <i class="fa fa-search me-1"></i> Search
                                    </button>
                                    <a href="{{ route('admin.doctor.index') }}" class="btn btn-light w-md">
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
