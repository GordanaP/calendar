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

<script>

/**
 * Highlight doctor absences.
 *
 * @param  FullCalendar\Object
 * @param  array doctorAbsences
 */
function highlightDoctorAbsences(fcDay, doctorAbsences, className="absence")
{
    var year = fcDay.date.getFullYear();
    var fcDate = formatDateObj(fcDay.date, 'YYYY-MM-DD');
    var calendarEl = fcDay.el;
    var exclusions = holidayDates(year);

    doctorAbsences.map(function(absence) {
        var start = moment(absence.day.start_at);
        var duration = absence.day.duration;
        var absenceDates = rangeOfDates(start, duration, exclusions);

        absenceDates.map(function(date) {
            if(isNotWeekend(new Date(date)) && isNotHoliday(new Date(date)) )
            {
                $('.fc-day[data-date="' + date + '"]').addClass('absence');
            }
        });

        if(fcDate == absenceDates[0]) {
            calendarEl.insertAdjacentHTML('beforeend', '<i class="fc-content" aria-hidden="true">'+ absence.type +'</i>');
        }
    });
}

/**
 * Determine if the doctor is not absente on a given date.
 *
 * @param  Javascrpt\date  date
 * @param  array  doctorAbsences
 * @return boolean
 */
function isNotDoctorAbsenceDate(date, doctorAbsences)
{
    var year = date.getFullYear();
    var formattedDate = formatDateObj(date, 'YYYY-MM-DD');
    var exclusions = holidayDates(year);

    return ! doctorAbsencesRanges(doctorAbsences, exclusions)
        .flat().includes(formattedDate);
}

/**
 * Doctor absences ranges.
 *
 * @param  array doctorAbsences
 * @param  array exclusions
 * @return array
 */
function doctorAbsencesRanges(doctorAbsences, exclusions)
{
    return doctorAbsences.map(function(absence){
        var start = moment(absence.day.start_at);
        var duration = absence.day.duration;

        return rangeOfDates(start, duration, exclusions);
    });
}

/**
 * The range of dates;
 *
 * @param  MomentJS\Date start
 * @param  integer duration
 * @param  array exclusions
 * @return array
 */
function rangeOfDates(start, duration, exclusions)
{
     var end = start.isoAddWeekdaysFromSet({
       'workdays': duration-1,
       'weekdays': [1,2,3,4,5],
       'exclusions': exclusions
     });

    var range = moment.range(start, end);

    return Array.from(range.by('day')).map(m => m.format('YYYY-MM-DD'));
}

/**
 * Determine if the given date is not holiday.
 *
 * @param  Javascript\Date  date
 * @return boolean
 */
function isNotHoliday(date)
{
    var year = date.getFullYear();
    var formattedDate = formatDateObj(date, 'YYYY-MM-DD');

    return ! holidayDates(year).includes(formattedDate);
}

/**
 * Determine if the given date is not the weekend day.
 *
 * @param  Javascript\Date  date
 * @return boolean
 */
function isNotWeekend(date)
{
    return date.getDay() !== 6 && date.getDay() !== 0;
}

/**
 * The holidays' dates.
 *
 * @param  integer year
 * @return array ['YYYY-MM-DD']
 */
function holidayDates(year)
{
    return holidays(year).map(function(holiday) {
         return holiday.dates.filter(function(holiday){
            return holiday != null;
        }).map(function(day){
            return formatDateObj(day, 'YYYY-MM-DD');
        });
    }).flat();
}

/**
 * All holidays - dates & names.
 *
 * @param  integer year
 * @return array
 */
function holidays(year)
{
    var public = publicHolidays(year);
    var religious = religiousHolidays(year);

    return $.merge(public, religious);
}

/**
 * Determine if the given date is not the weekend day.
 *
 * @param  Javascript\Date  date
 * @return boolean
 */
function isNotWeekend(date)
{
    return date.getDay() !== 6 && date.getDay() !== 0;
}


</script>