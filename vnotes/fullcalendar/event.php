events = i.o doctors appointments
----------------
events:  {
    url: doctorAppListUrl, // json response
},
eventRender: function(info) {
  $(info.el).tooltip({
    title: info.event.extendedProps.description,
    placement: "top",
    trigger: "hover",
    container: "body"
  });
},
eventTimeFormat: { // 09:00
    hour: 'numeric',
    minute: '2-digit',
    meridiem: false,
    hour12: false
},
eventLimit: eventLimit, // 5

if json response not wrapped (i.o $doctor->appointments->load('doctor', 'patient'))
---------------------------------------------------------
eventDataTransform: function(eventData) {
    transformToEventObj(eventData);
},

->
function transformToEventObj(event)
{
    event.title = event.patient.last_name;
    event.description = event.patient.birthday;
    event.start = event.start_at;
    event.end = event.end_at;
    event.backgroundColor = event.doctor.color;
    event.borderColor = event.doctor.color;
    // event.constraint = 'businessHours';

    return event;
}

-> b/c json response
[
    {
      "id": 1,
      "doctor_id": 1,
      "patient_id": 1,
      "start_at": "2020-03-14T09:00:00.000000Z",
      "created_at": "2020-03-09T05:52:13.000000Z",
      "updated_at": "2020-03-09T05:52:13.000000Z",
      "end_at": "2020-03-14 10:15:00",
      "patient": {
        "id": 1,
        "doctor_id": 3,
        "first_name": "Mireille",
        "last_name": "Sipes",
        "birthday": "1971-10-18",
        "created_at": "2020-03-09T05:52:12.000000Z",
        "updated_at": "2020-03-09T05:52:12.000000Z",
        "full_name": "Mireille Sipes"
      },
      "doctor": {
        "id": 1,
        "first_name": "Frederick",
        "last_name": "Pollich",
        "color": "#51635b",
        "app_slot": 15,
        "created_at": "2020-03-09T05:52:11.000000Z",
        "updated_at": "2020-03-09T05:52:11.000000Z",
        "full_name": "Frederick Pollich"
      }
    },
]

if json response is wrapped in array (data) i.o AppointmentResource::collection(
    $doctor->appointments->load('doctor', 'patient')
)
------------------------------------------------------------------
NO eventDataTransform

YES
eventSourceSuccess: function(content, xhr) {
    return content.data; //content.myArray
},

->b/c json response
"data": [
    {
      "id": 1,
      "title": "Mireille Sipes",
      "description": "1971-10-18",
      "start": "2020-03-14T09:00:00.000000Z",
      "end": "2020-03-14 10:15:00",
      "backgroundColor": "#51635b",
      "borderColor": "#51635b"
    },
