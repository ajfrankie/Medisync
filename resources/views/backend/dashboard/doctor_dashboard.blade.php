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


        <div class="col-xl-12">
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
