<div>
    <div id="calendar" wire:ignore></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el elemento html que tendrá el calendario
            var calendarEl = document.getElementById('calendar');
            var urlEventos = '/eventos/' + @js($tipoAgenda);

            // Crear calendario
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // Establecer idioma (Previamente se tiene que vincular el archivos locales.js)
                locale: 'es',
                themeSystem: 'bootstrap', //Tema
                initialView: 'dayGridMonth', //Día que se mostrará
                // Botones personalizados
                customButtons: {
                    //Dirige a la vista eventos propios (donde esta inscrito el usuario)
                    agendaPropia: {
                        text: 'Propia',
                        click: function() {
                            location.href = '/programacion/index/propios';
                        }
                    },
                    //Dirige a la vista eventos generales (públicos y  privados(donde esta inscrito el usuario))
                    agendaGeneral: {
                        text: 'General',
                        click: function() {
                            location.href = '/programacion/index/generales';
                        }
                    }
                },
                // Barra superior del calendarios
                headerToolbar: {
                    left: 'prev,next today agendaPropia agendaGeneral',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                // Array con los eventos que se mostrarán
                events: urlEventos,
                // Capturar evento cuando se hace click en una fecha
                dateClick: function(info) {
                    // Abrir el modal crear programa
                    Livewire.emit('create', info.dateStr);
                    // alert('Clicked on: ' + info.dateStr);
                    // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                    // alert('Current view: ' + info.view.type);
                    // // change the day's background color just for fun
                    // info.dayEl.style.backgroundColor = 'red';
                },
                // Capturar evento cuando se hace click en un evento o programa
                eventClick: function(info) {
                    // Abrir modal editar evento o programa
                    Livewire.emit('edit', info.event.id);
                    // alert('Event: ' + info.event.title);
                    // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                    // alert('View: ' + info.view.type);

                    // // change the border color just for fun
                    // info.el.style.borderColor = 'red';
                }
            });
            // Renderizar calendario
            calendar.render();
            //Refrescar el calendario cuando se realice algún cambio
            Livewire.on(`refreshCalendar`, () => {
                calendar.refetchEvents();
            });
        });
    </script>
    @include('livewire.programacion.create')
    @include('livewire.programacion.edit')
    @include('livewire.programacion.ver-recurso')
</div>
