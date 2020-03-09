@section('content')
    <h1>Calendar</h1>

    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var defaultView = 'timeGridWeek';
            var firstWeekDay = 1;
            var earliestBusinessOpen = @json(App::make('business-schedule')->businessHours()['open']);
            var latestBusinessClose = @json(App::make('business-schedule')->businessHours()['close']);

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
                slotLabelFormat: [
                    {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: false
                    }
                ],
                minTime: earliestBusinessOpen,
                maxTime: latestBusinessClose,
                dayRender: function(info) {
                    highlightHolidays(info)
                },
                selectable: true,
                selectAllow: function(info) {
                    var date = info.start;
                    return isNotPast(date) && isNotSunday(date) && isNotHoliday(date);
                }
            });

            calendar.render();
        });
    </script>
@endsection

