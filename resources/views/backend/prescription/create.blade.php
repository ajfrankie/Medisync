@extends('backend.layouts.master')

@section('title')
    Prescription Create
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Prescription
        @endslot
        @slot('title')
            Create
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('admin.prescription.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Success or Error Messages --}}
                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Medicine Input Groups -->
                        <div id="medicine-container" class="mt-4">
                            <div class="medicine-group border rounded p-3 mb-3">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Medicine Name</label>
                                        <input type="text" class="form-control" name="medicine_name[]"
                                            placeholder="e.g. Paracetamol">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Dosage</label>
                                        <input type="text" class="form-control" name="dosage[]"
                                            placeholder="e.g. 500 mg">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Frequency</label>
                                        <select class="form-control select" name="frequency[]">
                                            <option disabled selected>Choose...</option>
                                            <option value="Morning">Morning</option>
                                            <option value="Afternoon">Afternoon</option>
                                            <option value="Night">Night</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Duration</label>
                                        <input type="text" class="form-control" name="duration[]"
                                            placeholder="e.g. 5 days">
                                    </div>
                                </div>

                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-medicine">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Add Medicine Button -->
                        <div class="text-start mb-4">
                            <button type="button" class="btn btn-outline-success" id="add-medicine">
                                + Add Another Medicine
                            </button>
                        </div>

                        <hr>

                        <!-- Prescription Image Upload -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="prescription_img_path" class="form-label">Upload Prescription Image
                                    (Optional)</label>
                                <input type="file" class="form-control" name="prescription_img_path"
                                    id="prescription_img_path" accept="image/*">
                                <small class="text-muted d-block mt-1">
                                    If the doctor doesn’t have time, just upload a scanned prescription instead of adding
                                    each medicine manually.
                                </small>
                            </div>
                        </div>

                        <!-- Hidden Vital ID -->
                        <input type="hidden" name="vital_id" value="{{ $vital->id }}">


                        <!-- Form Buttons -->
                        <div class="text-end pe-3 mt-3 mb-3">
                            <a href="{{ route('admin.vital.index') }}" class="btn btn-outline-danger">Cancel</a>
                            <button type="submit" class="btn btn-outline-secondary w-md">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById('medicine-container');
            const addBtn = document.getElementById('add-medicine');

            // Add new medicine group
            addBtn.addEventListener('click', function() {
                const newGroup = container.firstElementChild.cloneNode(true);
                newGroup.querySelectorAll('input').forEach(el => el.value = '');
                newGroup.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
                container.appendChild(newGroup);
                $('.select2').select2(); // re-init Select2
            });

            // Remove a medicine group
            document.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-medicine')) {
                    const groups = document.querySelectorAll('.medicine-group');
                    if (groups.length > 1) {
                        e.target.closest('.medicine-group').remove();
                    }
                }
            });

            $('.select2').select2();
        });
    </script>
@endsection
