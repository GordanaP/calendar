<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- Moment -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.28/moment-timezone.min.js"></script>
<!-- Moment plugin to make date range -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-range/4.0.2/moment-range.js" integrity="sha256-bB6c2ZfNzG6Tv8MSu/pqUl0y91h86M/T+1w0WrCZhGw=" crossorigin="anonymous"></script>
<!-- Moment plugin to calculate dates for weekdays -->
<script src="{{ asset('vendor/moment-weekday-calc/src/moment-weekday-calc.js') }}"></script>

<script>
    window['moment-range'].extendMoment(moment);
</script>

<!-- FullCalendar -->
<script src="{{ asset('vendor/fullcalendar-4.3.1/packages/core/main.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar-4.3.1/packages/interaction/main.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar-4.3.1/packages/daygrid/main.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar-4.3.1/packages/timegrid/main.js') }}"></script>
<script src="{{ asset('vendor/fullcalendar-4.3.1/packages/list/main.js') }}"></script>

<!-- Custom -->
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/fc_absences.js') }}"></script>
<script src="{{ asset('js/fc_holidays.js') }}"></script>
<script src="{{ asset('js/fc_event.js') }}"></script>
<script src="{{ asset('js/modal_helpers.js') }}"></script>
<script src="{{ asset('js/form_helpers.js') }}"></script>

@yield('scripts')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        statusCode: {
            401: function() {
                redirectTo("{{ route('login') }}")
            },
            403: function() {
                alert('The action is unauthorized');
            }
        }
    });
</script>