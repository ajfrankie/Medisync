@extends('backend.layouts.master')

@section('title')
    Doctor Appointments Calendar
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/tui-time-picker/tui-time-picker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/tui-date-picker/tui-date-picker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/tui-calendar/tui-calendar.min.css') }}" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Doctor Appointments Calendar
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary move-day" data-action="move-prev">
                                <i class="mdi mdi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-primary move-today" data-action="move-today">
                                Today
                            </button>
                            <button type="button" class="btn btn-primary move-day" data-action="move-next">
                                <i class="mdi mdi-chevron-right"></i>
                            </button>
                        </div>

                        <h4 id="renderRange" class="fw-bold mb-0"></h4>

                        <div class="dropdown">
                            <button id="dropdownMenu-calendarType" class="btn btn-primary" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i id="calendarTypeIcon" class="calendar-icon ic_view_month"></i>
                                <span id="calendarTypeName">Month</span>
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu-calendarType">
                                <li><a class="dropdown-item" data-action="toggle-daily">Daily</a></li>
                                <li><a class="dropdown-item" data-action="toggle-weekly">Weekly</a></li>
                                <li><a class="dropdown-item" data-action="toggle-monthly">Monthly</a></li>
                            </ul>
                        </div>
                    </div>

                    <div id="calendar" style="height: 800px;"></div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- Toast UI Calendar Dependencies --}}
    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.min.js"></script>
    <script src="{{ URL::asset('build/libs/tui-dom/tui-dom.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/tui-time-picker/tui-time-picker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/tui-date-picker/tui-date-picker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/tui-calendar/tui-calendar.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const Calendar = tui.Calendar;

            // Initialize Calendar
            const calendar = new Calendar('#calendar', {
                defaultView: 'month',
                taskView: false,
                scheduleView: ['time'],
                useCreationPopup: false,
                useDetailPopup: true,
                isReadOnly: true,
                template: {
                    time: function(schedule) {
                        return `<strong>${schedule.title}</strong>`;
                    },
                    popupDetailDate: function(isAllDay, start, end) {
                        return moment(start.getTime()).format('YYYY-MM-DD hh:mm A');
                    },
                    popupDetailBody: function(schedule) {
                        return `Status: ${schedule.raw?.status ?? 'N/A'}`;
                    }
                }
            });

            // Appointment data from Laravel
            const appointments = @json($appointments);

            // Color codes for status
            const statusColors = {
                pending: '#f1b44c',
                confirmed: '#50a5f1',
                completed: '#34c38f',
                cancelled: '#f46a6a',
                'schedule next appointment': '#556ee6',
            };

            // Create schedule entries for calendar
            const schedules = appointments.map(a => ({
                id: String(a.id),
                calendarId: '1',
                title: `${a.title} (${a.state})`,
                category: 'time',
                start: a.start,
                end: a.end, // same or +30min defined in controller
                bgColor: statusColors[a.state] || '#50a5f1',
                borderColor: statusColors[a.state] || '#50a5f1',
                raw: {
                    status: a.state
                }
            }));

            calendar.createSchedules(schedules);

            // Calendar navigation
            document.querySelectorAll('.move-day').forEach(btn => {
                btn.addEventListener('click', () => {
                    const action = btn.getAttribute('data-action');
                    if (action === 'move-prev') calendar.prev();
                    if (action === 'move-next') calendar.next();
                    updateRenderRange();
                });
            });

            document.querySelector('.move-today').addEventListener('click', () => {
                calendar.today();
                updateRenderRange();
            });

            // Calendar view change (month/week/day)
            document.querySelectorAll('[data-action^="toggle-"]').forEach(item => {
                item.addEventListener('click', () => {
                    const action = item.getAttribute('data-action');
                    if (action === 'toggle-daily') calendar.changeView('day', true);
                    if (action === 'toggle-weekly') calendar.changeView('week', true);
                    if (action === 'toggle-monthly') calendar.changeView('month', true);
                    updateRenderRange();
                });
            });

            // Display date range on top
            function updateRenderRange() {
                const start = calendar.getDateRangeStart().toDate();
                const end = calendar.getDateRangeEnd().toDate();
                const range = `${start.toLocaleDateString()} - ${end.toLocaleDateString()}`;
                document.getElementById('renderRange').textContent = range;
            }

            updateRenderRange();
        });
    </script>
@endsection
