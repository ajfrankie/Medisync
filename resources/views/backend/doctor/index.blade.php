@extends('backend.layouts.master')

@section('title')
    Doctors
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Doctors
        @endslot
        @slot('title')
            Doctors
        @endslot
    @endcomponent

    @include('backend.doctor.filter')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">Doctors</h5>
                        <a href="{{ route('admin.doctor.create') }}" class="btn btn-primary w-md">
                            <i class="fas fa-plus me-1"></i>
                            Create Doctor
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <table class="table align-middle dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Doctor Name</th>
                                    <th scope="col">Specialization</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Avilabilty</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctors as $doctor)
                                    <tr>
                                        <td>{{ $doctor->user->name ?? 'N/A' }}</td>
                                        <td>{{ $doctor->specialization_formatted ?? 'N/A'  }}</td>
                                        <td>{{ $doctor->department_formatted ?? 'N/A'  }}</td>
                                        <td>
                                            @if ($doctor->is_activated)
                                                <span class="badge bg-success">Avilable</span>
                                            @else
                                                <span class="badge bg-danger">Not Avilable</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group text-nowrap" role="group">
                                                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded fs-5" style="color:#898787"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">

                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.doctor.show', $doctor->id) }}">
                                                        <i class="bx bx-edit-alt"></i>Show
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.doctor.edit', $doctor->id) }}">
                                                        <i class="bx bx-edit-alt"></i>Edit
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.doctor.destroy', $doctor->id) }}">
                                                        <i class="bx bx-bin-alt"></i> Delete </a>
                                                    </a>

                                                    <a href="#status{{ $doctor->id }}" data-bs-toggle="modal"
                                                        class="dropdown-item btn ">
                                                        @if ($doctor->is_activated)
                                                            <i class="bx bx-x"></i> Deactivate
                                                        @else
                                                            <i class="bx bx-check"></i>Activate
                                                        @endif
                                                    </a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('backend.doctor.delete')
                                    @include('backend.doctor.status')
                                @endforeach
                            </tbody>
                        </table>
                        <!-- end table -->
                    </div>
                    <!-- end table responsive -->
                </div>
                <!-- end card body -->
                <div class="text-end">
                    <ul class="pagination-rounded">
                        {{ $doctors->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
