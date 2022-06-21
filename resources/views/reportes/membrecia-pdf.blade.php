@include('reportes.encabezado',['nombreReporte'=>'Miembros'])
<div class="div-centrar-tabla">
    <table class="table table-hover table-sm table responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Tipo Miembro</th>
                <th>No. Asistencias</th>
                <th>Fecha última asistencia</th>
                <th>Tiempo que no asiste</th>
                <th>Lugar última asistencia</th>
                <th>Último evento asistido</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dato)
                <tr>
                    <td>{{ $dato->idMiembro }}</td>
                    <td>{{ $dato->nombremiembro }}</td>
                    <td>{{ $dato->categoriaedad }}</td>
                    <td>{{Carbon\Carbon::parse($dato->fecha_conversion)->diffInMonths()<3?'Nuevo':'Antiguo';}}</td>
                    <td>{{ $dato->numeroasistencias }}</td>
                    <td>{{ $dato->fechaultimoprograma }}</td>
                    <td>{{Carbon\Carbon::parse($dato->FechaUltimoPrograma)->diffForHumans()}}</td>
                    <td>{{ $dato->nombreultimoprograma }}</td>
                    <td>{{ $dato->nombreultimolugar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>