@extends('backend.layouts.master')

@section('title')
    Create Supportive Document
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Supportive Documents
        @endslot
        @slot('title')
            Create
        @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form method="POST" action="{{ route('admin.document.store') }}" enctype="multipart/form-data">
                        @csrf
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        {{-- Auto-fill hidden patient_id --}}
                        <input type="hidden" name="patient_id" value="{{ $patient_id }}">
                        {{-- <p class="text-muted">Debug: Patient ID = {{ $patient_id ?? 'Not Found' }}</p> --}}


                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        <div class="row mt-3">
                            <!-- Title -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Document Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}" placeholder="Enter document title">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="file_path" class="form-label">Upload File <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="file_path" id="file_path"
                                        class="form-control @error('file_path') is-invalid @enderror"
                                        accept=".pdf,.doc,.jpg,.png,.jpeg">
                                    @error('file_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description (Optional)</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="form-control @error('description') is-invalid @enderror" placeholder="Enter document description...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="text-end pe-3 mt-3 mb-2">
                            <a href="{{ route('admin.document.index') }}" class="btn btn-outline-danger">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-outline-secondary w-md">
                                Upload
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endsection
