/**
 * Highlight the doctor's non-working days.
 *
 * @param  Javascript\Date date
 * @param  array doctorAbsences
 * @param  array doctorOfficeDays
 * @param  string holidayClass
 * @param  string absenceClass
 * @return array
 */
function markDoctorOfficeDays(date, doctorOfficeDays, doctorAbsences, holidayClass="holiday", absenceClass="absence")
{
    var year = date.getFullYear();
    var holidays = holidayDates(year);
    var formattedDate = jQuery.datepicker.formatDate('yy-mm-dd', date);

    if (isSunday(date) || isHoliday(date)) {
        return [false, holidayClass];
    } else if (isDoctorAbsenceDate(formattedDate, doctorAbsences)) {
        return [false, absenceClass];
    } else if (! isDoctorOfficeDay(date, doctorOfficeDays)) {
        return [false, "", ""];
    } else {
        return [true];
    }
}