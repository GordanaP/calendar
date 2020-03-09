
/**
 * Determine if the given date is the doctor's office day.
 *
 * @param  Javascript\Date  date
 * @param  \Illuminate\Support\Collection  doctorOfficeDays
 * @return boolean
 */
function isDoctorOfficeDay(date, doctorOfficeDays)
{
    var dateIso = date.getDay();

    return doctorOfficeDays.map(function(day) {
        return day.iso;
    }).includes(dateIso);
}

/**
 * Find the specific doctor's office day.
 *
 * @param  Javascript\Date
 * @param  \Illuminate\Support\Collection doctorOfficeDays
 * @return \App\BusinessDay
 */
function findDoctorOfficeDay(date, doctorOfficeDays)
{
    return doctorOfficeDays.find(x => x.iso === date.getDay());
}

/**
 * Determine if the given time is within the doctor's office hours.
 *
 * @param  Javascript\Date
 * @param  \Illuminate\Support\Collection  doctorOfficeDays
 * @param  string  format
 * @return boolean
 */
function isDoctorOfficeHour(date, doctorOfficeDays, format="HH:mm:ss")
{
    var officeDay = findDoctorOfficeDay(date, doctorOfficeDays);

    var startTime = moment(officeDay.hour.start_at, format);
    var endTime = moment(officeDay.hour.end_at, format);
    var formattedTime = formatDateObj(date, format)
    var selected = moment(formattedTime, format);

    return  selected >= startTime && selected < endTime;
}

/**
 * The doctor's office hours.
 *
 * @param  Illuminate\Support\Collection doctorOfficeDays
 * @return array
 */
function doctorOfficeHours(doctorOfficeDays)
{
    return doctorOfficeDays.map(function(day) {
        var officeHours = {};

        officeHours.daysOfWeek = [day.iso];
        officeHours.startTime = formatDateString(day.hour.start_at, 'HH:mm:ss', 'HH:mm')
        officeHours.endTime = formatDateString(day.hour.end_at, 'HH:mm:ss', 'HH:mm')

        return officeHours;
    });
}