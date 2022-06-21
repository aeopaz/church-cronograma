@include('reportes.encabezado',['nombreReporte'=>'Actividades'])
<div class="div-centrar-tabla">
    <table class="table table-hover table-sm table responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo Programa</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Lugar</th>
                <th>Asistentes</th>
                <th>Nuevos</th>
                <th>Antiguos</th>
                <th>Puntuales</th>
                <th>Retrasados</th>
                <th>Llegaron Final</th>
                <th>Organizador</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dato)
                <tr>
                    <td>{{ $dato->idPrograma }}</td>
                    <td>{{ $dato->tipoprograma }}</td>
                    <td>{{ $dato->nombrePrograma }}</td>
                    <td>{{ $dato->fechaPrograma . ' ' . $dato->horaPrograma }}</td>
                    <td>{{ $dato->lugar }}</td>
                    <td>{{ $dato->numeroasistentes }}</td>
                    <td>{{ $dato->numeronuevos }}</td>
                    <td>{{ $dato->numeroantiguos }}</td>
                    <td>{{ $dato->numeropuntuales }}</td>
                    <td>{{ $dato->numeroretrasados }}</td>
                    <td>{{ $dato->numerollegaronfinalizando }}</td>
                    <td>{{ $dato->usuarioorganizador }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>