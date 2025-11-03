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
                                                <a href="javascript:void(0);"
                                                    class="text-decoration-underline text-primary view-file"
                                                    data-file="{{ asset('storage/' . $document->file_path) }}"
                                                    data-title="{{ $document->title }}">
                                                    View File
                                                </a>
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

    <!-- Modal for Viewing File -->
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">Document Viewer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="fileFrame" src="" width="100%" height="600px" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileModal = new bootstrap.Modal(document.getElementById('fileModal'));
            const fileFrame = document.getElementById('fileFrame');
            const fileTitle = document.getElementById('fileModalLabel');

            document.querySelectorAll('.view-file').forEach(link => {
                link.addEventListener('click', function() {
                    const fileUrl = this.getAttribute('data-file');
                    const title = this.getAttribute('data-title');

                    // Set the modal title and file URL
                    fileTitle.textContent = title || "Document Viewer";
                    fileFrame.src = fileUrl;

                    // Show the modal
                    fileModal.show();
                });
            });

            // Clear iframe when modal closes
            document.getElementById('fileModal').addEventListener('hidden.bs.modal', () => {
                fileFrame.src = "";
            });
        });
    </script>
@endsection
