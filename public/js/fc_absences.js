/**
 * Highlight doctor absences.
 *
 * @param  FullCalendar\Object
 * @param  array doctorAbsences
 */
function highlightDoctorAbsences(fcDay, doctorAbsences, className="absence")
{
    var fcDate = formatDateObj(fcDay.date, 'YYYY-MM-DD');
    var calendarEl = fcDay.el;

    doctorAbsences.map(function(absence) {
        absence.dates.map(function(date) {
            $('.fc-day[data-date="' + date + '"]').addClass(className);
        });

        if(fcDate == absence.dates[0]) {
            calendarEl.insertAdjacentHTML('beforeend', '<i class="fc-content" aria-hidden="true">'+ absence.type +'</i>');
        }
    });
}

/**
 * Determine if the doctor is not absente on the given date.
 *
 * @param  Javascrpt\date  date
 * @param  array  absencesDates
 * @return boolean
 */
function isNotDoctorAbsenceDate(date, doctorAbsences)
{
    var formattedDate = formatDateObj(date, 'YYYY-MM-DD');
    var absencesDates = [];

    for (var i = 0; i < doctorAbsences.length; i++) {
        absencesDates.push(doctorAbsences[i].dates);
    }

    return ! absencesDates.flat().includes(formattedDate);
}
