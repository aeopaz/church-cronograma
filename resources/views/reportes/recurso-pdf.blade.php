@include('reportes.encabezado',['nombreReporte'=>'Recursos'])
<div class="div-centrar-tabla">
    <table class="table table-hover table-sm table responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo Recurso</th>
                <th>Ministerio</th>
                <th>Veces utilizado</th>
                <th>Fecha última</th>
                <th>Tiempo no utilizado</th>
                <th>Lugar</th>
                <th>Último evento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dato)
                <tr>
                    <td>{{ $dato->idRecurso }}</td>
                    <td>{{ $dato->nombre }}</td>
                    <td>{{ $dato->tiporecurso }}</td>
                    <td>{{ $dato->ministerio }}</td>
                    <td>{{ $dato->vecesutilizado }}</td>
                    <td>{{ $dato->fechaultimoprograma }}</td>
                    <td>{{Carbon\Carbon::parse($dato->fechaultimoprograma)->diffForHumans()}}</td>
                    <td>{{ $dato->nombreultimoprograma }}</td>
                    <td>{{ $dato->nombreultimolugar }}</td>
                
                </tr>
            @endforeach
        </tbody>
    </table>

</div>