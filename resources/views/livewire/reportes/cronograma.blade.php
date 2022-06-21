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
    {{-- Filtrar por Rol --}}
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Roles:</h6>
        <select class="form-control" wire:model='idRol'>
            <option value="%%">Todos</option>
            @foreach ($listaRoles as $rol)
                <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
            @endforeach
        </select>
    </div>
    {{-- Filtrar por Participante --}}
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Participante:</h6>
        <select class="form-control" wire:model='idParticipante'>
            <option value="%%">Todos</option>
            @foreach ($listaUsuarios as $usuario)
                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
            @endforeach
        </select>
    </div>
</div>
@include('componentes.paginador')
<div class="div-centrar-tabla">
    <table class="table table-hover table-sm table-responsive">
        <thead>
            <tr>
                <th>ID Progama</th>
                <th>Ministerio</th>
                <th>Programa</th>
                <th>Fecha y Hora</th>
                <th>Encargado</th>
                <th>Función</th>
                <th>Acción</th>
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
                    <td><button class="btn btn-primary"
                            wire:click='verPrograma({{ $dato->idPrograma }})'>Ver</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
</div>
