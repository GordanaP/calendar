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
    return  isNotPast(date) &&
            isNotHoliday(date) &&
            isNotSunday(date) &&
            isNotDoctorAbsenceDate(date, doctorAbsences);
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
 * Determine if the given date is not Sunday.
 *
 * @param  Javascript\Date  date
 * @return boolean
 */
function isNotSunday(date)
{
    return date.getDay() !== 0;
}

/**
 * Determine if the given date is not in the past.
 *
 * @param  mixed  date
 * @return boolean
 */
function isNotPast(date)
{
    return moment(date).isAfter(moment());
}
