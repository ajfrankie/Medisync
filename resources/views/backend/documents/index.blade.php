@extends('backend.layouts.master')

@section('title')
    Supportive Documents
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Documents
        @endslot
        @slot('title')
            Supportive Documents
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <!-- Header -->
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 card-title">Supportive Documents</h5>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-striped dt-responsive nowrap w-100 table-check">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Patient Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $document)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $document->patient->user->name ?? 'N/A' }}</td>
                                        <td>{{ $document->title }}</td>
                                        <td>{{ Str::limit($document->description, 40) ?? '-' }}</td>
                                        <td>
                                            @if ($document->file_path)
                                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                                                    class="text-decoration-underline">View File</a>
                                            @else
                                                <span class="text-muted">No File</span>
                                            @endif
                                        </td>
                                      
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No documents found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="text-end">
                    <ul class="pagination-rounded">
                        {{ $documents->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
