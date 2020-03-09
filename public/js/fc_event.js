
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