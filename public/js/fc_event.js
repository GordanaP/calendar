
/**
 * Remove the event from the calendar.
 *
 * @param  FullCalendar calendar
 * @param  integer eventId
 */
function removeEvent(calendar, eventId)
{
    var eventObj = calendar.getEventById(eventId);

    eventObj.remove();
}

/**
 * Update the calendar event.
 *
 * @param  Fullcalendar calendar
 * @param  \App\Model event
 */
function updateEvent(calendar, event)
{
    var eventObj = calendar.getEventById(event.id);
    var newStart = new Date(event.start_at);
    var newEnd = new Date(event.end_at);

    eventObj.setDates(newStart, newEnd);
}

/**
 * Add the event to the calendar.
 *
 * @param FullCalendar calendar
 * @param App\Model event
 */
function addEvent(calendar, event)
{
    var eventObj = transformToEventObj(event);

    calendar.addEvent(eventObj);
}

/**
 * Transform custom data into a standard Fullcalendar Event Object.
 *
 * @param  \App\Model event
 * @return Fullcalendar\Event Object
 */
function transformToEventObj(event)
{
    event.title = event.patient.short_name;
    event.description = event.doctor.last_name;
    event.start = event.start_at;
    event.end = event.end_at;
    event.backgroundColor = event.doctor.color;
    event.borderColor = event.doctor.color;
    // event.constraint = 'businessHours';

    return event;
}