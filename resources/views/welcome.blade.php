@extends('layouts.app')

@section('links')
    <style type="text/css">
        .holiday, .holiday span.ui-state-default { background-color: coral; }
        .absence, .absence span.ui-state-default { background-color: yellow; }
        .office-day a.ui-state-default {background-color: lightgreen}
    </style>
@endsection

@section('content')
    @php
        $patient = App\Patient::first();
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

        var appModal = $('#scheduleAppModal');
        var appForm = $('#scheduleAppForm');
        var appDate = $('#appDate');
        var appTime = $('#appTime');
        var appButton = $('.app-button');
        var deleteAppButton = $('#deleteAppButton');
        var errors = ['patient_id', 'app_date', 'app_time'];


        appModal.clearContentOnClose(errors);
        clearErrorOnTriggeringAnEvent();

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
            var doctorOfficeHours = @json(App::make('doctor-schedule')->setDoctor($doctor)->officeHours());
            var doctorSchedulingTimeSlot = @json($doctor->app_slot);
            var slotDuration = formatDateString(doctorSchedulingTimeSlot, 'mm', 'HH:mm:ss');
            var doctorAbsences = @json(App::make('doctor-absences')->setDoctor($doctor)->all());
            var doctorAppListUrl = @json(route('doctors.appointments.list', $doctor));
            var doctorSchedulingSlotsUrl = @json(route('doctors.scheduling.time.slots', $doctor));

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
                    var date = selectInfo.start;
                    var eventDate = formatDateObj(date, dateFormat);
                    var eventTime = formatDateObj(date, timeFormat);

                    appModal.open();
                    appDate.val(eventDate);
                    appTime.val(eventTime);
                    appButton.text('Schedule').attr('id', 'scheduleAppButton');
                    deleteAppButton.hide();

                    $.ajax({
                        url: doctorSchedulingSlotsUrl,
                        type: 'POST',
                        data: {
                            app_date: eventDate
                        },
                    })
                    .done(function(response) {
                        var minTime = response.minTime;
                        var maxTime = response.maxTime;
                        var bookedSlots = response.bookedSlots;

                        appTime.timepicker({
                            'timeFormat': 'H:i',
                            'step': doctorSchedulingTimeSlot,
                            'minTime': minTime,
                            'maxTime': maxTime,
                            'disableTimeRanges': bookedSlots,
                        });
                    });
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
                    var event = clickInfo.event;
                    var eventId = event.id;
                    var eventDate = formatDateObj(event.start, dateFormat);
                    var eventTime = formatDateObj(event.start, timeFormat);

                    appModal.open();
                    appDate.val(eventDate);
                    appTime.val(eventTime);
                    appButton.text('Reschedule').attr('id', 'rescheduleAppButton')
                        .val(eventId);
                    deleteAppButton.show().val(eventId);
                },
                eventDrop:function(dropInfo) {
                    var event = dropInfo.event;
                    var eventId = event.id;
                    var eventDate = formatDateObj(event.start, dateFormat);
                    var eventTime = formatDateObj(event.start, timeFormat);
                    var rescheduleAppUrl = '/appointments/' + eventId;

                    var data = {
                        app_date: eventDate,
                        app_time: eventTime,
                    }

                    $.ajax({
                        url: rescheduleAppUrl,
                        type: 'PUT',
                        data: data,
                    })
                    .done(function(response) {
                        updateEvent(calendar, response.appointment);
                    })
                    .fail(function() {
                        console.log("error");
                    });
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

            // Add appointment
            $(document).on('click', '#scheduleAppButton', function() {
                var data = appForm.serializeArray();
                var scheduleAppUrl = @json(route('doctors.appointments.store', $doctor));

                $.ajax({
                    url: scheduleAppUrl,
                    type: 'POST',
                    data: data,
                })
                .done(function(response) {
                    addEvent(calendar, response.appointment);
                    appModal.close();
                })
                .fail(function(response) {
                    var errors = response.responseJSON.errors;
                    displayErrors(errors);
                });
            });

            // Update appointment
            $(document).on('click',  '#rescheduleAppButton', function(){
                var appId = $(this).val();
                var data = appForm.serializeArray();
                var rescheduleAppUrl = '/appointments/' + appId;

                $.ajax({
                    url: rescheduleAppUrl,
                    type: 'PUT',
                    data: data,
                })
                .done(function(response) {
                    updateEvent(calendar, response.appointment);
                    appModal.close();
                    console.log(response.message)
                })
                .fail(function(response) {
                    var errors = response.responseJSON.errors;
                    displayErrors(errors);
                });
            });

            // Remove appointment
            $(document).on('click', '#deleteAppButton', function() {
                var appId = $(this).val();
                var deleteAppUrl = '/appointments/' + appId;

                $.ajax({
                    url: deleteAppUrl,
                    type: 'DELETE',
                })
                .done(function(response) {
                    removeEvent(calendar, appId);
                    appModal.close();
                })
                .fail(function() {
                    console.log("error");
                });
            });

            appDate.datepicker({
                onSelect: function(date) {

                    appTime.timepicker('remove');
                    appTime.val('')

                    $.ajax({
                        url: doctorSchedulingSlotsUrl,
                        type: 'POST',
                        data: {
                            app_date: date
                        },
                    })
                    .done(function(response) {
                        var minTime = response.minTime;
                        var maxTime = response.maxTime;
                        var bookedSlots = response.bookedSlots;

                        appTime.timepicker({
                            'timeFormat': 'H:i',
                            'step': doctorSchedulingTimeSlot,
                            'minTime': minTime,
                            'maxTime': maxTime,
                            'disableTimeRanges': bookedSlots,
                        });
                    });
                },
                firstDay: 1,
                dateFormat: "yy-mm-dd",
                minDate: 0,
                changeMonth: true,
                changeYear: true,
                beforeShowDay: function(date) {
                    return markDoctorOfficeDays(date, doctorOfficeDays, doctorAbsences)
                }
            });
        });


    </script>
@endsection
