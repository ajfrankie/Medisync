@extends('backend.layouts.master')

@section('title')
    @lang('translation.Dashboards')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="bg-primary-subtle">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>Medisync Dashboard</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ URL::asset('build/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">

                        {{-- LEFT SIDE – AVATAR & NAME --}}
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">

                                @php
                                    $user = auth()->user();
                                    $avatar = $user->avatar ? asset($user->avatar) : null;
                                    $initials = strtoupper(substr($user->name ?? '', 0, 2));

                                    if ($user->doctor) {
                                        $text = $user->doctor->specialization ?? 'Doctor';
                                    } elseif ($user->patient) {
                                        $text = 'Patient';
                                    } else {
                                        $text = ucfirst($user->role ?? 'User');
                                    }
                                @endphp

                                @if ($avatar)
                                    <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle mb-2" width="120"
                                        height="120" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2"
                                        style="width:120px; height:120px; font-size:36px; font-weight:bold;">
                                        {{ $initials }}
                                    </div>
                                @endif

                                <h5 class="font-size-15">{{ Str::ucfirst($user->name) }}</h5>

                                <p class="text-muted mb-0 text-truncate">{{ $text }}</p>
                            </div>
                        </div>

                        {{-- RIGHT SIDE – APPOINTMENT STATS --}}
                        <div class="col-xl-8">
                            <div class="pt-4">

                                <div class="row">

                                    <!-- Pending (warning) -->
                                    <div class="col-3">
                                        <div class="p-3 rounded bg-warning text-white">
                                            <h5 class="font-size-15 fw-bold">{{ $totalPendingAppointments }}</h5>
                                            <p class="mb-0">Pending</p>
                                        </div>
                                    </div>

                                    <!-- Confirmed (primary) -->
                                    <div class="col-3">
                                        <div class="p-3 rounded bg-primary text-white">
                                            <h5 class="font-size-15 fw-bold">{{ $totalConfirmedAppointments }}</h5>
                                            <p class="mb-0">Confirmed</p>
                                        </div>
                                    </div>

                                    <!-- Cancelled (danger) -->
                                    <div class="col-3">
                                        <div class="p-3 rounded bg-danger text-white">
                                            <h5 class="font-size-15 fw-bold">{{ $totalCancledAppointments }}</h5>
                                            <p class="mb-0">Cancelled</p>
                                        </div>
                                    </div>

                                    <!-- Completed (success) -->
                                    <div class="col-3">
                                        <div class="p-3 rounded bg-success text-white">
                                            <h5 class="font-size-15 fw-bold">{{ $totalCompletedAppointments }}</h5>
                                            <p class="mb-0">Completed</p>
                                        </div>
                                    </div>

                                </div>

                                {{-- VIEW PROFILE BUTTON (Right Side + Secondary Color) --}}
                                <div class="mt-4 d-flex justify-content-end">
                                    @if ($user->patient)
                                        <a href="{{ route('admin.patient.showPatient', $user->patient->id) }}"
                                            class="btn btn-secondary waves-effect waves-light btn-sm">
                                            View Profile <i class="mdi mdi-arrow-right ms-1"></i>
                                        </a>
                                    @elseif($user->doctor)
                                        <a href="{{ route('admin.doctor.showDoctor', $user->doctor->id) }}"
                                            class="btn btn-secondary waves-effect waves-light btn-sm">
                                            View Profile <i class="mdi mdi-arrow-right ms-1"></i>
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row">

                <!-- LEFT SIDE - 8 columns (Notifications Table) -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Notifications</h4>

                            <div class="table-responsive">
                                <table class="table align-middle dt-responsive nowrap w-100 table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notifications as $notification)
                                            <tr>
                                                <td>{{ $notification->subject ?? 'N/A' }}</td>
                                                <td>{{ Str::limit($notification->message, 80) }}</td>
                                                <td class="text-center">
                                                    @if ($notification->is_viewed)
                                                        <i class="fas fa-envelope-open text-success font-size-18"></i>
                                                    @else
                                                        <i class="fas fa-envelope text-warning font-size-18"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE - 4 columns (USER DETAILS CARD) -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">

                            @php
                                $user = auth()->user();
                            @endphp

                            <h4 class="mb-3">User Details</h4>

                            <ul class="list-unstyled mb-0">

                                <li class="mb-2">
                                    <strong>Name:</strong> {{ $user->name }}
                                </li>

                                <li class="mb-2">
                                    <strong>Email:</strong> {{ $user->email ?? 'N/A' }}
                                </li>

                                <li class="mb-2">
                                    <strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}
                                </li>

                                <li class="mb-2">
                                    <strong>Date of Birth:</strong>
                                    {{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : 'N/A' }}
                                </li>

                            </ul>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- end row -->
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>
@endsection
