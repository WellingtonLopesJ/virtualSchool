<link href='fullcalendar/main.css' rel='stylesheet' />

<script src='fullcalendar/main.js'></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {


            initialView: 'timeGridDay',
            selectable: true,
            selectOverlap: false,
            select: function(info) {

                let date = new Date(Date.parse(info.startStr));
                let formated = date.toLocaleDateString() + " - " + date.toLocaleTimeString()

                document.getElementById('start').value = info.startStr;
                document.getElementById('end').value = info.endStr;
                document.getElementById('lessonStart').innerHTML =  formated;

                $('#basicModal').modal('show')
            },
            events: '/fetchLessons',

            headerToolbar: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
                right: 'prev,next today'
            },

            slotMinTime: "07:00:00",
            slotMaxTime: "18:30:00",
            slotDuration: "00:30",
            snapDuration: "00:40",

            expandRows: true
        });
        calendar.render();
    });

</script>


<div id="calendar"></div>

