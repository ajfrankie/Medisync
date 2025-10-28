@extends('backend.layouts.master')

@section('title')
    EHR Records
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            EHR Records
        @endslot
        @slot('title')
            EHR Records
        @endslot
    @endcomponent

    @include('backend.ehr.filter')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">EHR Records</h5>
                        <a href="{{ route('admin.ehr.create') }}" class="btn btn-outline-primary w-md">
                            <i class="fas fa-plus me-1"></i>
                            Create EHR Record
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Dcotor's Name</th>
                                    <th scope="col">Patient's Name</th>
                                    <th scope="col">Visit Date</th>
                                    <th scope="col">Diagnosis</th>
                                    <th scope="col">Treatment Summary</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ehrs as $ehr)
                                    <tr>
                                        <td>{{ $ehr->doctor->user->name ?? 'N/A' }}</td>
                                        <td>{{ $ehr->patient->user->name ?? 'N/A' }}</td>
                                        <td>{{ $ehr->visit_date ?? 'N/A' }}</td>
                                        <td>{{ $ehr->diagnosis ?? 'N/A' }}</td>
                                        <td>{{ $ehr->treatment_summary ?? 'N/A' }}</td>

                                        <td>
                                            <div class="btn-group text-nowrap" role="group">
                                                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded fs-5" style="color:#898787"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">

                                                    <a class="dropdown-item" href="{{ route('admin.ehr.show', $ehr->id) }}">
                                                        <i class="bx bx-edit-alt"></i>Show
                                                    </a>

                                                    <a class="dropdown-item" href="{{ route('admin.ehr.edit', $ehr->id) }}">
                                                        <i class="bx bx-edit-alt"></i>Edit
                                                    </a>

                                                    {{-- <a class="dropdown-item"
                                                        href="{{ route('admin.vital.index', ['ehr_id' => $ehr->id]) }}">
                                                        <i class="bx bx-edit-alt"></i>Vitals
                                                    </a> --}}


                                                </div>
                                            </div>
                                        </td>
                                    </tr>
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
                        {{ $ehrs->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
