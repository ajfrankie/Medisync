@extends('backend.layouts.master')

@section('title')
    Patients
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Patients
        @endslot
        @slot('title')
            Patients
        @endslot
    @endcomponent

    @include('backend.patient.filter')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">Patient</h5>
                        <a href="{{ route('admin.patient.create') }}" class="btn btn-outline-primary w-md">
                            <i class="fas fa-plus me-1"></i>
                            Create Patient
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Patient's Name</th>
                                    <th scope="col">Patient's Phone</th>
                                    <th scope="col">Blood Gorup</th>
                                    <th scope="col">Emergency Person</th>
                                    <th scope="col">Emergency Person No</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $patient)
                                    <tr>
                                        <td>{{ $patient->user->name ?? 'N/A' }}</td>
                                        <td>{{ $patient->user->phone ?? 'N/A' }}</td>
                                        <td>{{ $patient->blood_group ?? 'N/A' }}</td>
                                        <td>
                                            <div>
                                                <h6 class="text-truncate font-size-14">
                                                    {{ $patient->emergency_person }}
                                                </h6>
                                                <p class="text-muted mb-0">
                                                    <span>{{ $patient->emergency_relationship }}</span>
                                                </p>
                                            </div>
                                        </td>
                                        <td>{{ $patient->emergency_contact ?? 'N/A' }}</td>

                                        <td>
                                            <div class="btn-group text-nowrap" role="group">
                                                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded fs-5" style="color:#898787"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">

                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.patient.show', $patient->id) }}">
                                                        <i class="bx bx-edit-alt"></i>Show
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.patient.edit', $patient->id) }}">
                                                        <i class="bx bx-edit-alt"></i>Edit
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.ehr.index', $patient->id) }}">
                                                        <i class="bx bx-edit-alt"></i>EHR Records
                                                    </a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="text-end">
                    <ul class="pagination-rounded">
                        {{ $patients->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection
