@extends('backend.layouts.master')

@section('title', 'Vitals')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            prescription
        @endslot
        @slot('title')
            prescription Record
        @endslot
    @endcomponent

    {{-- @include('backend.nurse.filter') --}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">prescription</h5>
                        {{-- <a href="{{ route('admin.prescription.create', ['vital_id' => $vital->id]) }}"
                            class="btn btn-outline-primary w-md">

                            <i class="fas fa-plus me-1"></i> prescription Vital
                        </a> --}}
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Doctor</th>
                                    <th>Diagnosis</th>
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prescriptions as $prescription)
                                    <tr>
                                        <td>{{ $prescription->vital->ehrRecord->doctor->user->name ?? 'N/A' }}</td>
                                        <td>{{ $prescription->vital->ehrRecord->diagnosis ?? 'N/A' }}</td>
                                        <td>{{ $prescription->created_at ?? 'N/A' }}</td>
                                    
                                        <td>
                                            <div class="btn-group text-nowrap" role="group">
                                                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded fs-5" style="color:#898787"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.prescription.showPrescription', $prescription->id) }}">
                                                        <i class="bx bx-show-alt"></i> Show
                                                    </a>
                                                    
                                                    {{-- <a class="dropdown-item"
                                                        href="{{ route('admin.prescription.index', ['vital' => $vital->id]) }}">
                                                        <i class="bx bx-plus-circle"></i> Prescription Details
                                                    </a> --}}

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
                    {{ $prescriptions->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                </ul>
            </div>
        </div>
    </div>
@endsection
