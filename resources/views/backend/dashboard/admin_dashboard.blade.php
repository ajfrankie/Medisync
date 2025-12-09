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
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Doctors</p>
                                    <h4 class="mb-0">{{ $countDoctors ?? '0' }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-success mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-success">
                                            <i class="bx bxs-user-detail font-size-24"></i>
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
                                    <p class="text-muted fw-medium">Admin</p>
                                    <h4 class="mb-0">{{ $countAdmins ?? '0' }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-warning mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-warning">
                                            <i class="bx bx-user-check font-size-24"></i>
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
                                    <p class="text-muted fw-medium">Patients</p>
                                    <h4 class="mb-0">{{ $countPatients ?? '0' }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-danger mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-danger">
                                            <i class="bx bx-bed font-size-24"></i>
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
                                    <p class="text-muted fw-medium">Nurse</p>
                                    <h4 class="mb-0">{{ $countNurses ?? '0' }}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-danger mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-danger">
                                            <i class="bx bx-first-aid font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Complete Appointments</h4>
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="mt-2 mt-sm-0">
                                <div id="radialBar-chart-0" data-colors='["--bs-primary"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Pending Appointments</h4>
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="mt-2 mt-sm-0">
                                <div id="radialBar-chart-1" data-colors='["--bs-warning"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Cancelled Appointments</h4>
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="mt-2 mt-sm-0">
                                <div id="radialBar-chart-2" data-colors='["--bs-danger"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- dataset --}}


    </div>
    <!-- end row -->
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Grab PHP variable
            var appointmentsPercentage = {{ $appointmentsPercentage ?? 0 }};

            // Grab colors from data attribute
            var chartColors = JSON.parse(document.querySelector("#radialBar-chart-0").getAttribute("data-colors"));
            chartColors = chartColors.map(function(value) {
                return getComputedStyle(document.documentElement).getPropertyValue(value) || value;
            });

            var options = {
                chart: {
                    height: 280,
                    type: 'radialBar',
                },
                series: [appointmentsPercentage],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%'
                        },
                        dataLabels: {
                            name: {
                                show: true
                            },
                            value: {
                                show: true,
                                fontSize: '24px',
                                formatter: function(val) {
                                    return val + "%";
                                }
                            }
                        }
                    }
                },
                colors: chartColors,
                labels: ['Completed'],
            };

            var chart = new ApexCharts(document.querySelector("#radialBar-chart-0"), options);
            chart.render();
        });
    </script>
     <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Grab PHP variable
            var appointmentsPercentage = {{ $pendingAppoinmentPercentage ?? 0 }};

            // Grab colors from data attribute
            var chartColors = JSON.parse(document.querySelector("#radialBar-chart-1").getAttribute("data-colors"));
            chartColors = chartColors.map(function(value) {
                return getComputedStyle(document.documentElement).getPropertyValue(value) || value;
            });

            var options = {
                chart: {
                    height: 280,
                    type: 'radialBar',
                },
                series: [appointmentsPercentage],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%'
                        },
                        dataLabels: {
                            name: {
                                show: true
                            },
                            value: {
                                show: true,
                                fontSize: '24px',
                                formatter: function(val) {
                                    return val + "%";
                                }
                            }
                        }
                    }
                },
                colors: chartColors,
                labels: ['Pending'],
            };

            var chart = new ApexCharts(document.querySelector("#radialBar-chart-1"), options);
            chart.render();
        });
    </script>
     <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Grab PHP variable
            var appointmentsPercentage = {{ $cancelledAppoinmentPercentage ?? 0 }};

            // Grab colors from data attribute
            var chartColors = JSON.parse(document.querySelector("#radialBar-chart-2").getAttribute("data-colors"));
            chartColors = chartColors.map(function(value) {
                return getComputedStyle(document.documentElement).getPropertyValue(value) || value;
            });

            var options = {
                chart: {
                    height: 280,
                    type: 'radialBar',
                },
                series: [appointmentsPercentage],
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%'
                        },
                        dataLabels: {
                            name: {
                                show: true
                            },
                            value: {
                                show: true,
                                fontSize: '24px',
                                formatter: function(val) {
                                    return val + "%";
                                }
                            }
                        }
                    }
                },
                colors: chartColors,
                labels: ['Cancelled'],
            };

            var chart = new ApexCharts(document.querySelector("#radialBar-chart-2"), options);
            chart.render();
        });
    </script>
@endsection
