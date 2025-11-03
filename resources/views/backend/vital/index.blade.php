@extends('backend.layouts.master')

@section('title', 'Vitals')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Vitals
        @endslot
        @slot('title')
            Vital Record
        @endslot
    @endcomponent

    {{-- @include('backend.nurse.filter') --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">Vitals</h5>
                        <a href="{{ route('admin.vital.create', ['ehr_id' => $ehr->id]) }}" class="btn btn-outline-primary w-md">

                            <i class="fas fa-plus me-1"></i> Create Vital
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Recorded Doctor</th>
                                    <th>Temperature</th>
                                    <th>Blood Pressure</th>
                                    <th>Pulse Rate</th>
                                    <th>Oxygen Level</th>
                                    <th>Blood Suger</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vitals as $vital)
                                    <tr>
                                        <td>{{ $vital->ehrRecord->patient->user->name ?? 'N/A' }}</td>
                                        <td>{{ $vital->ehrRecord->doctor->user->name ?? 'N/A' }}</td>
                                        <td>{{ $vital->temperature ?? 'N/A' }}</td>
                                        <td>{{ $vital->blood_pressure ?? 'N/A' }}</td>
                                        <td>{{ $vital->pulse_rate ?? 'N/A' }}</td>
                                        <td>{{ $vital->oxygen_level ?? 'N/A' }}</td>
                                        <td>{{ $vital->blood_sugar ?? 'N/A' }}</td>
                                        <td>
                                            <div class="btn-group text-nowrap" role="group">
                                                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded fs-5" style="color:#898787"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.vital.show', $vital->id) }}">
                                                        <i class="bx bx-show-alt"></i> Show
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.nurse.edit', $vital->id) }}">
                                                        <i class="bx bx-edit-alt"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.prescription.show', $vital->id) }}">
                                                        <i class="bx bx-edit-alt"></i> prescription 
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No vital records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <ul class="pagination-rounded">
                    {{ $vitals->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                </ul>
            </div>
        </div>
    </div>
@endsection
