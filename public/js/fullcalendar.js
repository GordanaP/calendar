/**
 * Format the date string.
 *
 * @param  string dateString
 * @param  string stringFormat
 * @param  string newFormat
 * @return string
 */
function formatDateString(dateString, stringFormat, newFormat)
{
    return moment(dateString, stringFormat).format(newFormat);
}

/**
 * Format the Javascript date object.
 *
 * @param  Javascript\Date dateObj
 * @param  string format
 * @return string
 */
function formatDateObj(dateObj, format)
{
    return moment(dateObj).format(format);
}

/**
 * Determine if the given date can be selected for scheduling.
 *
 * @param  Javascript\Date  date
 * @param  array doctorAbsences
 * @return boolean
 */
function isSelectable(date, doctorAbsences)
{
    return  ! isPast(date) &&
            ! isHoliday(date) &&
            ! isDoctorAbsenceDate(date, doctorAbsences);
}

/**
 * Determine if the given date is Sunday.
 *
 * @param  Javascript\Date  date
 * @return boolean
 */
function isSunday(date)
{
    return date.getDay() == 0;
}

/**
 * Determine if the given time is in the past.
 *
 * @param  mixed  dateTime
 * @return boolean
 */
function isPast(dateTime)
{
    var d1 = moment(dateTime);
    var d2 = moment();

    return d2.diff(d1, 'minutes') > 0;
}

