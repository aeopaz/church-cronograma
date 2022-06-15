@include('reportes.encabezado')
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
                <th>Retrazados</th>
                <th>Llegaron Final</th>
                <th>Organizador</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dato)
                <tr>
                    <td>{{ $dato->idPrograma }}</td>
                    <td>{{ $dato->tipoPrograma }}</td>
                    <td>{{ $dato->nombrePrograma }}</td>
                    <td>{{ $dato->fechaPrograma . ' ' . $dato->horaPrograma }}</td>
                    <td>{{ $dato->lugar }}</td>
                    <td>{{ $dato->numeroAsistentes }}</td>
                    <td>{{ $dato->numeroNuevos }}</td>
                    <td>{{ $dato->numeroAnTiguos }}</td>
                    <td>{{ $dato->numeroPuntuales }}</td>
                    <td>{{ $dato->numeroRetrazados }}</td>
                    <td>{{ $dato->numeroLlegaronFinalizando }}</td>
                    <td>{{ $dato->usuarioOrganizador }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>