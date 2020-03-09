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

    @include('partials.appointments._schedule_modal')
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
            var doctorOfficeHours = @json(App::make('doctor-schedule')->setDoctor($doctor)->officeHours());

            var appModal = $('#scheduleAppModal');


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
                businessHours: doctorOfficeHours,
                slotDuration: slotDuration,
                slotLabelFormat: [
                    {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: false
                    }
                ],
                dayRender: function(renderInfo) {
                    highlightHolidays(renderInfo);
                    highlightDoctorAbsences(renderInfo, doctorAbsences);
                },
                selectable: true,
                selectAllow: function(selectInfo) {
                    return isSelectable(selectInfo.start, doctorAbsences);
                },
                selectConstraint: 'businessHours',
                select: function(selectInfo) {
                    appModal.open()
                },
                events:  {
                    url: doctorAppListUrl,
                },
                eventSourceSuccess: function(response, xhr) {
                    return response.data;
                },
                eventRender: function(renderInfo) {
                  $(renderInfo.el).tooltip({
                    title: renderInfo.event.extendedProps.description,
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
                eventClick: function(clickInfo) {
                    // open the update appointment modal
                },
                eventDrop:function(dropInfo) {
                    //
                },
                eventOverlap: false,
                eventAllow: function(dropInfo, draggedEvent) {
                    return isSelectable(dropInfo.start, doctorAbsences)
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
