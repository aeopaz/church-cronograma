@include('reportes.encabezado', ['nombreReporte' => 'Informe Programa'])
<div>
    {{-- Información Programa --}}
    <div class="seccion">
        <div class="row">
            <h2 class="titulo">Información Programa</h2>
        </div>
        <table class="table table-hover table-sm table responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo Programa</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Organizador</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>{{ $datosPrograma->idPrograma }}</td>
                    <td>{{ $datosPrograma->tipoprograma }}</td>
                    <td>{{ $datosPrograma->nombrePrograma }}</td>
                    <td>{{ $datosPrograma->fecha . ' ' . $datosPrograma->hora }}</td>
                    <td>{{ $datosPrograma->lugar }}</td>
                    <td>{{ $datosPrograma->usuarioorganizador }}</td>
                </tr>

            </tbody>
        </table>
    </div>
    {{-- Resumen Asistencia --}}
    <div class="seccion">
        <div class="row">
            <h2 class="titulo">Resumen Asistencia</h2>
        </div>
        <table class="table table-hover table-sm table responsive">
            <thead>
                <tr>
                    <th>Asistentes</th>
                    <th>Nuevos</th>
                    <th>Antiguos</th>
                    <th>Puntuales</th>
                    <th>Retrasados</th>
                    <th>Llegaron Final</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $datosPrograma->numeroasistentes }}</td>
                    <td>{{ $datosPrograma->numeronuevos }}</td>
                    <td>{{ $datosPrograma->numeroantiguos }}</td>
                    <td>{{ $datosPrograma->numeropuntuales }}</td>
                    <td>{{ $datosPrograma->numeroretrasados }}</td>
                    <td>{{ $datosPrograma->numerollegaronfinalizando }}</td>
                </tr>

            </tbody>
        </table>
    </div>
       {{-- Nombre personas que asistieron --}}
    <div class="seccion">
        <div class="row">
            <h2 class="titulo">Personas que Asistieron</h2>
        </div>
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>LLegada</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosAsistentes as $asistente)
                    <tr>
                        <td>{{ $asistente->nombreMiembro . ' ' . $asistente->apellidoMiembro }}
                        </td>
                        <td>{{Carbon\Carbon::parse($asistente->fechaConversion)->diffInMonths()<3?'Nuevo':'Antiguo';}}</td>
                        <td>{{ $asistente->tipoLlegada }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
       {{-- Participantes --}}
    <div class="seccion">
        <div class="row">
            <h2 class="titulo">Detalle Distribución Privilegios</h2>
        </div>
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Ministerio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosParticipantes as $participante)
                    <tr>
                        <td>{{ $participante->nombreParticipante }}
                        </td>
                        <td>{{ $participante->nombreRol }}</td>
                        <td>{{ $participante->nombreMinisterio }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('reportes.pie-pagina')
