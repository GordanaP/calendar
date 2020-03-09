@extends('layouts.app')

@section('links')
    <style type="text/css">
        .holiday { background-color: coral; }
        .absence { background-color: green; }
    </style>
@endsection

@section('content')
    @php
        $doctor = App\Doctor::first();
    @endphp

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>

@endsection

@section('scripts')
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var defaultView = 'timeGridWeek';
            var dateFormat = "YYYY-MM-DD";
            var timeFormat = "HH:mm";
            var firstWeekDay = 1;
            var eventLimit = 6;
            var earliestBusinessOpen = @json(App::make('business-schedule')->theEarliestOpen());
            var latestBusinessClose = @json(App::make('business-schedule')->theLatestClose());
            var doctorOfficeDays = @json($doctor->business_days);
            var doctorSchedulingTimeSlot = @json($doctor->app_slot);
            var slotDuration = formatDateString(doctorSchedulingTimeSlot, 'mm', 'HH:mm:ss');
            var doctorAbsences = @json(App::make('doctor-absences')->setDoctor($doctor)->all());
            var doctorAppListUrl = @json(route('doctors.appointments.list', $doctor));

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth, timeGridWeek, timeGridDay, listDay'
                },
                navLinks: true,
                defaultView: defaultView,
                firstDay: firstWeekDay,
                minTime: earliestBusinessOpen,
                maxTime: latestBusinessClose,
                businessHours: doctorOfficeHours(doctorOfficeDays),
                slotDuration: slotDuration,
                slotLabelFormat: [
                    {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: false
                    }
                ],
                dayRender: function(info) {
                    highlightHolidays(info);
                    highlightDoctorAbsences(info, doctorAbsences);
                },
                selectable: true,
                selectAllow: function(info) {
                    var date = info.start;
                    return isSelectable(date, doctorAbsences);
                },
                selectConstraint: 'businessHours',
                select: function(info) {
                    // open the scheduling modal
                },
                events:  {
                    url: doctorAppListUrl,
                },
                eventSourceSuccess: function(content, xhr) {
                    return content.data;
                },
                eventRender: function(info) {
                  $(info.el).tooltip({
                    title: info.event.extendedProps.description,
                    placement: "top",
                    trigger: "hover",
                    container: "body"
                  });
                },
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                eventLimit: eventLimit,
                eventClick: function(info) {
                    console.log(info)
                },
                eventDrop:function(info) {
                    console.log(info)
                },
                views: {
                    timeGrid: {
                        editable: true,
                    },
                }
            });

            calendar.render();
        });

    </script>
@endsection
