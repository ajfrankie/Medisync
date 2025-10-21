@extends('backend.layouts.master')

@section('title')
    Nurses
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Nurses
        @endslot
        @slot('title')
            Nurses
        @endslot
    @endcomponent

    @include('backend.nurse.filter')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">Nurses</h5>
                        <a href="{{ route('admin.nurse.create') }}" class="btn btn-outline-primary w-md">
                            <i class="fas fa-plus me-1"></i>
                            Create Nurse
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Nurse's Name</th>
                                    <th scope="col">Nurse's Phone</th>
                                    <th scope="col">Shift Time</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Avilabilty</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nurses as $nurse)
                                    <tr>
                                        <td>{{ $nurse->user->name ?? 'N/A' }}</td>
                                        <td>{{ $nurse->user->phone ?? 'N/A' }}</td>
                                        <td>{{ $nurse->department ?? 'N/A'  }}</td>
                                        <td>{{ $nurse->shift_time ?? 'N/A'  }}</td>
                                        <td>
                                            @if ($nurse->is_activated)
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
                                                        href="{{ route('admin.nurse.show', $nurse->id) }}">
                                                        <i class="bx bx-edit-alt"></i>Show
                                                    </a>

                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.nurse.edit', $nurse->id) }}">
                                                        <i class="bx bx-edit-alt"></i>Edit
                                                    </a>

                                                    <a href="#status{{ $nurse->id }}" data-bs-toggle="modal"
                                                        class="dropdown-item btn ">
                                                        @if ($nurse->is_activated)
                                                            <i class="bx bx-x"></i> Deactivate
                                                        @else
                                                            <i class="bx bx-check"></i>Activate
                                                        @endif
                                                    </a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('backend.nurse.status')
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
                        {{ $nurses->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
