<link href='fullcalendar/main.css' rel='stylesheet' />

<script src='fullcalendar/main.js'></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridDay',

            events: '/fetchLessons',

            headerToolbar: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
                right: 'prev,next today'
            },

            slotMinTime: "07:00:00",
            slotMaxTime: "18:30:00",

            expandRows: true
        });
        calendar.render();
    });

</script>

<div id="calendar"></div>
