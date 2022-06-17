@if (count($data) == 0)
    <div class="div-centrar-tabla">No hay registros para mostrar</div>
@else
    @include('componentes.paginador')
    <div class="div-centrar-tabla">


        <table class="table table-hover table-sm table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Día de Cumpleaños</th>
                    <th>Días faltantes</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($data as $dato)
                    <tr class="{{ $dato->diaAnoNacimiento - $dato->diaAnoActual <= 0 ? 'table-success' : '' }}">
                        <td>{{ $dato->idMiembro }}</td>
                        <td>{{ $dato->nombre . ' ' . $dato->apellido }}</td>
                        <td>{{ $dato->fecha_nacimiento->format('M-j') }}</td>
                        <td>{{ $dato->diaAnoNacimiento - $dato->diaAnoActual <= 0 ? 0 : $dato->diaAnoNacimiento - $dato->diaAnoActual }}
                            días</td>
                        <td><button class="btn btn-primary"
                                wire:click='verMiembro({{ $dato->idMiembro }})'>Ver</button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{ $data->links() }}

    </div>
@endif
