@include('reportes.encabezado')
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
                    <td>{{ $dato->nombreMIembro }}</td>
                    <td>{{ $dato->categoriaEdad }}</td>
                    <td>{{Carbon\Carbon::parse($dato->fecha_conversion)->diffInMonths()<3?'Nuevo':'Antiguo';}}</td>
                    <td>{{ $dato->numeroAsistencias }}</td>
                    <td>{{ $dato->FechaUltimoPrograma }}</td>
                    <td>{{Carbon\Carbon::parse($dato->FechaUltimoPrograma)->diffForHumans()}}</td>
                    <td>{{ $dato->nombreUltimoPrograma }}</td>
                    <td>{{ $dato->nombreUltimoLugar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>