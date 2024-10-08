<div>
    {{-- Filtrar por evento --}}

    <div class="form-group row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="">Filtrar por programa:</label>
            <select name="" id="tipoPrograma" class="form-control" wire:model='tipoPrograma'>
                <option value="0">Seleccione</option>
                @foreach ($listaTipoPrograma as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>
        {{-- Filtro por lugar Programa --}}
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="">Filtrar por Lugar:</label>
            <select name="" id="lugar" class="form-control " wire:model='lugar'>
                <option value="0">Seleccione</option>
                @foreach ($listaLugares as $lugar)
                    <option value="{{ $lugar->id }}">{{ $lugar->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>




    <div id="calendar" wire:ignore></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el elemento html que tendrá el calendario
            var calendarEl = document.getElementById('calendar');
            var urlEventos = @js($urlConsultaEventos);

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
                    },
                    //Generar eventos de cumpleaños
                    @canany(['admin', 'lider'])
                        generarCumpleanos: {
                            text: 'Generar cumple',
                            click: function() {
                                Livewire.emit('generarEventoCumpleanos');
                            }
                        }
                    @endcan
                },
                // Barra superior del calendarios
                headerToolbar: {
                    left: 'prev,next today agendaPropia agendaGeneral generarCumpleanos',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                },
                // Array con los eventos que se mostrarán
                events: urlEventos,
                // Capturar evento cuando se hace click en una fecha
                //Solo los admin y lideres pueden crear eventos
                @canany(['admin', 'lider'])
                    dateClick: function(info) {
                        // Abrir el modal crear programa
                        Livewire.emit('create', info.dateStr);
                        // alert('Clicked on: ' + info.dateStr);
                        // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                        // alert('Current view: ' + info.view.type);
                        // // change the day's background color just for fun
                        // info.dayEl.style.backgroundColor = 'red';
                    },
                @endcan
                //Eventos máximos para mostrar en undía
                dayMaxEventRows: true, // for all non-TimeGrid views
                views: {
                    dayGrid: {
                        dayMaxEventRows: 6 // adjust to 6 only for timeGridWeek/timeGridDay
                    }
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
            //Filtrar por programa
            tipoPrograma.addEventListener('change', function() {
                if (tipoPrograma.value > 0 && lugar.value > 0) {
                    let tipoAgenda = @js($tipoAgenda);
                    location.href = '/programacion/index/' + tipoAgenda + '/' + tipoPrograma.value + '/' +
                        lugar.value;
                    return;
                }
                if (tipoPrograma.value > 0) {
                    let tipoAgenda = @js($tipoAgenda);
                    location.href = '/programacion/index/' + tipoAgenda + '/' + tipoPrograma.value;
                    return;

                }
                if (lugar.value > 0) {
                    let tipoAgenda = @js($tipoAgenda);
                    location.href = '/programacion/index/' + tipoAgenda + '/null/' + lugar.value;
                    return;

                }
                location.href = '/programacion/index/' + tipoAgenda;

            });
            //Filtrar por Lugar
            lugar.addEventListener('change', function() {
                if (tipoPrograma.value > 0 && lugar.value > 0) {
                    let tipoAgenda = @js($tipoAgenda);
                    location.href = '/programacion/index/' + tipoAgenda + '/' + tipoPrograma.value + '/' +
                        lugar.value;
                    return;
                }
                if (tipoPrograma.value > 0) {
                    let tipoAgenda = @js($tipoAgenda);
                    location.href = '/programacion/index/' + tipoAgenda + '/' + tipoPrograma.value;
                    return;

                }
                if (lugar.value > 0) {
                    let tipoAgenda = @js($tipoAgenda);
                    location.href = '/programacion/index/' + tipoAgenda + '/0/' + lugar.value;
                    return;

                }
                location.href = '/programacion/index/' + tipoAgenda;
            });
        });
    </script>
    @include('livewire.programacion.create')
    @include('livewire.programacion.edit')
    @include('livewire.programacion.ver-recurso')
</div>
