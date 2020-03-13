function highlightDoctorNonWorkingDates(date, doctorAbsences, className="holiday")
{
    return (highlightDatepickerHolidays(date, className) &&
        highlightDatepickerDoctorAbsences(date, doctorAbsences, className))
}

function highlightDatepickerHolidays(date, doctorAbsences, className="holiday")
{
    var year = date.getFullYear();
    var holidays = holidayDates(year);
    var formattedDate = formatDatepickerDate(date);

    if (isSunday(date) || isHoliday(date)) {
        return [false, "holiday"];
    } else if(isDoctorAbsenceDate(formattedDate, doctorAbsences)) {
        return [false, "absence"];
    } else {
        return [true];
    }
}

function highlightDatepickerDoctorAbsences(date, doctorAbsences, className="absence")
{
    var formattedDate = formatDatepickerDate(date);

    return ! isDoctorAbsenceDate(formattedDate, doctorAbsences) ? [true] : [false, className];
}

function getBookedSlots(slots)
{
    var bookedSlots = [];

    for (var i = 0; i < slots.length; i++) {
       bookedSlots.push([slots[i].start, slots[i].end]);
    }

    return bookedSlots;
}

function formatDatepickerDate(date)
{
    return jQuery.datepicker.formatDate('yy-mm-dd', date);
}
