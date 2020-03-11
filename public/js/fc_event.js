/**
 * Remove the event from the calendar.
 *
 * @param  FullCalendar calendar
 * @param  integer eventId
 */
function removeEvent(calendar, eventId) {
    calendar.getEventById(eventId).remove();
}

/**
 * Update the calendar event.
 *
 * @param  FullCalendar calendar
 * @param  JSON event
 */
function updateEvent(calendar, event) {
    var newStart = new Date(event.start_at);
    var newEnd = new Date(event.end_at);

    calendar.getEventById(event.id).setDates(newStart, newEnd);
}

/**
 * Add the event.
 *
 * @param FullCalendar calendar
 * @param JSON event
 */
function addEvent(calendar, event) {
    var eventObj = transformToEventObj(event);
    calendar.addEvent(eventObj);
}

/**
 * Transform custom data into a standard Fullcalendar Event Object.
 *
 * @param  JSON event
 * @return Fullcalendar\Event Object
 */
function transformToEventObj(event) {
    event.title = event.patient.last_name;
    event.description = event.patient.birthday;
    event.start = event.start_at;
    event.end = event.end_at;
    event.backgroundColor = event.doctor.color;
    event.borderColor = event.doctor.color;

    return event;
}
