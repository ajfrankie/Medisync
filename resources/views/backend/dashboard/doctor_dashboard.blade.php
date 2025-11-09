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
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                {{-- title bar --}}
                <div class="bg-primary-subtle">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back!</h5>
                                <p>MEDISYNC</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ URL::asset('build/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                {{-- Profile Section --}}
                <div class="card-body pt-0">
                    <div class="row">

                        <div class="col-sm-4 text-center mb-4">
                            @php
                                $avatar = $user->avatar ? asset($user->avatar) : null;
                                $initials = strtoupper(substr($user->name ?? '', 0, 2));
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

                            <h5 class="font-size-15 text-truncate">{{ Str::ucfirst($user->name) }}</h5>
                            <p class="text-muted mb-0 text-truncate">
                                {{ $doctor->specialization ?? 'Specialization not set' }}</p>
                        </div>

                        {{-- Stats Section --}}
                        <div class="col-sm-8">
                            <div class="pt-4">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{ $completedAppointments ?? 0 }}</h5>
                                        <p class="text-muted mb-0">Completed Appointments</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">{{ $pendingAppointments ?? 0 }}</h5>
                                        <p class="text-muted mb-0">Pending Appointments</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="card">
                <div class="card-body">
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

        <div class="col-xl-8">
            <div class="row">
                <!-- Confirmed Appointments -->
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Confirmed Appointments</p>
                                    <h4 class="mb-0">{{ $confirmedAppointmentsByMonth }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-check-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Appointments -->
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Pending Appointments</p>
                                    <h4 class="mb-0">{{ $pendingAppointmentsByMonth }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-warning">
                                        <span class="avatar-title">
                                            <i class="bx bx-time-five font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cancelled Appointments -->
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Cancelled Appointments</p>
                                    <h4 class="mb-0">{{ $cancledAppointmentsByMonth }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-danger">
                                        <span class="avatar-title">
                                            <i class="bx bx-x-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Appointments -->
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Completed Appointments</p>
                                    <h4 class="mb-0">{{ $completedAppointmentsByMonth }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                        <span class="avatar-title">
                                            <i class="bx bx-check-double font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end row -->

            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex flex-wrap">
                        <h4 class="card-title mb-4">Appointments Overview</h4>
                        <div class="ms-auto">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Week</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Month</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Year</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
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

    {{-- ApexCharts Script --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.0"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: false
                    },
                },
                series: [{
                        name: 'Completed',
                        data: @json($yearAppointmetDetails['completed'] ?? [])
                    },
                    {
                        name: 'Pending',
                        data: @json($yearAppointmetDetails['pending'] ?? [])
                    },
                    {
                        name: 'Cancelled',
                        data: @json($yearAppointmetDetails['cancelled'] ?? [])
                    },
                    {
                        name: 'Confirmed',
                        data: @json($yearAppointmetDetails['confirmed'] ?? [])
                    },
                ],
                xaxis: {
                    categories: @json($yearAppointmetDetails['months'] ?? []),
                    title: {
                        text: 'Months'
                    }
                },
                yaxis: {
                    min: 0,
                    tickAmount: 8, // number of intervals on Y-axis
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(1); // show decimals like 0.5, 1.0, 1.5
                        }
                    },
                    title: {
                        text: 'Appointments'
                    }
                },
                colors: ['#28a745', '#ffc107', '#dc3545', '#007bff'],
                legend: {
                    position: 'top'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '60%',
                        borderRadius: 5
                    }
                },
                dataLabels: {
                    enabled: false
                },
                grid: {
                    borderColor: '#f1f1f1'
                }
            };

            var chart = new ApexCharts(document.querySelector("#stacked-column-chart"), options);
            chart.render();
        });
    </script>
@endsection
