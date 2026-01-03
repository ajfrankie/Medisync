@extends('backend.layouts.master')

@section('title')
    @lang('translation.Dashboards')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Patient Dashboard
        @endslot
    @endcomponent

    <div class="row">

        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Appointmet Date</p>
                                    <h4 class="mb-0">{{ $AppointmentDate ?? 'N/A' }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Complete Appointment</p>
                                    <h4 class="mb-0">{{ $completedAppointments ?? 'N/A' }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-archive-in font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Next Appointmet</p>
                                    <h4 class="mb-0">{{ $nextAppointmentDate ?? 'N/A' }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Cancle Aopintment </p>
                                    <h4 class="mb-0">{{ $cancleAppointment ?? 'N/A' }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-purchase-tag-alt font-size-24"></i>
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

            {{-- vital Details --}}
            <div class="row">
                {{-- Sugar Level Details --}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Vital Detail – Sugar Level</h4>
                            <h5>
                                {{ $sugarDetails['value'] ?? 'N/A' }} mg/dL
                                <span class="badge bg-{{ $sugarDetails['color'] }}">
                                    {{ $sugarDetails['status'] }}
                                </span>
                            </h5>
                            <div class="progress mt-3">
                                <div class="progress-bar bg-{{ $sugarDetails['color'] }}" role="progressbar"
                                    style="width: {{ $sugarDetails['percentage'] }}%"
                                    aria-valuenow="{{ $sugarDetails['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Blood Pressure Details --}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Vital Detail – Blood Pressure</h4>
                            <h5>
                                {{ $bloodPressure['value'] ?? 'N/A' }} mmHg
                                <span class="badge bg-{{ $bloodPressure['color'] }}">
                                    {{ $bloodPressure['status'] }}
                                </span>
                            </h5>
                            <div class="progress mt-3">
                                <div class="progress-bar bg-{{ $bloodPressure['color'] }}" role="progressbar"
                                    style="width: {{ $bloodPressure['percentage'] }}%"
                                    aria-valuenow="{{ $bloodPressure['percentage'] }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pulse Rate Details --}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Vital Detail – Pulse Rate</h4>
                            <h5>
                                {{ $pulseRate['value'] ?? 'N/A' }} bpm
                                <span class="badge bg-{{ $pulseRate['color'] }}">
                                    {{ $pulseRate['status'] }}
                                </span>
                            </h5>
                            <div class="progress mt-3">
                                <div class="progress-bar bg-{{ $pulseRate['color'] }}" role="progressbar"
                                    style="width: {{ $pulseRate['percentage'] }}%"
                                    aria-valuenow="{{ $pulseRate['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BMI Details --}}
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Vital Detail – BMI</h4>

                            <h5>
                                {{ $bmiDetails['bmi'] ?? 'N/A' }}
                                <span
                                    class="badge 
                    @if ($bmiDetails['category'] === 'Underweight') bg-danger
                    @elseif($bmiDetails['category'] === 'Normal weight') bg-success
                    @elseif($bmiDetails['category'] === 'Overweight') bg-info
                    @else bg-warning @endif">
                                    {{ $bmiDetails['category'] }}
                                </span>
                            </h5>

                            <div class="progress mt-3">
                                @php
                                    $percentage = match ($bmiDetails['category'] ?? '') {
                                        'Underweight' => 30,
                                        'Normal weight' => 70,
                                        'Overweight' => 85,
                                        'Obese' => 95,
                                        default => 0,
                                    };
                                    $color = match ($bmiDetails['category'] ?? '') {
                                        'Underweight' => 'danger',
                                        'Normal weight' => 'success',
                                        'Overweight' => 'info',
                                        'Obese' => 'warning',
                                        default => 'secondary',
                                    };
                                @endphp

                                <div class="progress-bar bg-{{ $color }}" role="progressbar"
                                    style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
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
