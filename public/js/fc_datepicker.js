function highlightDoctorNonWorkingDates(date, doctorAbsences, holidayClass="holiday", absenceClass="absence")
{
    var year = date.getFullYear();
    var holidays = holidayDates(year);
    var formattedDate = formatDatepickerDate(date);

    if (isSunday(date) || isHoliday(date)) {
        return [false, holidayClass];
    } else if (isDoctorAbsenceDate(formattedDate, doctorAbsences)) {
        return [false, absenceClass];
    } else {
        return [true];
    }
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
