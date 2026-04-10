<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de avisos</title>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #calendar {
            max-width: 1100px;
            margin: 0 auto;
        }

        .top-links {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="top-links">
        <a href="<?= BASE_URL ?>/admin">Volver al panel</a>
    </div>

    <h1>Calendario de avisos</h1>

    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: <?= json_encode($events) ?>,
                eventClick: function(info) {
                    const event = info.event;
                    const props = event.extendedProps;

                    alert(
                        'Localizador: ' + event.title + '\n' +
                        'Cliente: ' + props.cliente + '\n' +
                        'Técnico: ' + props.tecnico + '\n' +
                        'Urgencia: ' + props.urgencia + '\n' +
                        'Estado: ' + props.estado + '\n' +
                        'Descripción: ' + props.descripcion
                    );
                }
            });

            calendar.render();
        });
    </script>

</body>
</html>