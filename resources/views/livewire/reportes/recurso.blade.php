<div class="form-group row">
    {{-- Filtrar por Ministerio --}}
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Ministerio:</h6>
        <select class="form-control" wire:model='idTipoMinisterio'>
            <option value="%%">Todos</option>
            @foreach ($listaMinisterios as $ministerio)
                <option value="{{ $ministerio->id }}">{{ $ministerio->nombre }}</option>
            @endforeach
        </select>
    </div>
    {{-- Filtrar por Tipo Recurso --}}
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Tipo Recurso:</h6>
        <select class="form-control" wire:model='idTipoRecurso'>
            <option value="%%">Todos</option>
            @foreach ($listaTipoRecursos as $tipoRecurso)
                <option value="{{ $tipoRecurso->id }}">{{ $tipoRecurso->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>
@include('componentes.paginador')
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
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dato)
                <tr>
                    <td>{{ $dato->idRecurso }}</td>
                    <td>{{ $dato->nombre }}</td>
                    <td>{{ $dato->tipoRecurso }}</td>
                    <td>{{ $dato->ministerio }}</td>
                    <td>{{ $dato->vecesUtilizado }}</td>
                    <td>{{ $dato->FechaUltimoPrograma }}</td>
                    <td>{{Carbon\Carbon::parse($dato->FechaUltimoPrograma)->diffForHumans()}}</td>
                    <td>{{ $dato->nombreUltimoPrograma }}</td>
                    <td>{{ $dato->nombreUltimoLugar }}</td>
                    <td><button class="btn btn-primary" wire:click='verRecurso({{ $dato->idRecurso }})'>Ver</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
</div>
