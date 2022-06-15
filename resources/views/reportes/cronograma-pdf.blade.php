@include('reportes.encabezado')
<h2 class="titulo">Cronograma de Ministerios</h2>
<div class="div-centrar-tabla">
    <table class="table table-hover table-sm table responsive">
        <thead>
            <tr>
                <th>ID Progama</th>
                <th>Ministerio</th>
                <th>Programa</th>
                <th>Fecha y Hora</th>
                <th>Encargado</th>
                <th>Función</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dato)
                <tr>
                    <td>{{ $dato->idPrograma }}</td>
                    <td>{{ $dato->nombreMinisterio }}</td>
                    <td>{{ $dato->nombrePrograma }}</td>
                    <td>{{ $dato->fechaPrograma . ' ' . $dato->horaPrograma }}</td>
                    <td>{{ $dato->nombreParticipante }}</td>
                    <td>{{ $dato->nombreRol }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('reportes.pie-pagina')
