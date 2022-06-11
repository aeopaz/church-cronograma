<div class="form-group row">
    {{-- Filtrar por Tipo Programa --}}
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Tipo Programa:</h6>
        <select class="form-control" wire:model='tipoPrograma'>
            <option value="%%">Todos</option>
            @foreach ($listaTipoProgramas as $lista)
                <option value="{{ $lista->id }}">{{ $lista->nombre }}</option>
            @endforeach
        </select>
    </div>
    {{-- Filtrar por Lugar --}}
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Lugar:</h6>
        <select class="form-control" wire:model='tipoLugarPrograma'>
            <option value="%%">Todos</option>
            @foreach ($listaLugares as $lista)
                <option value="{{ $lista->id }}">{{ $lista->nombre }}</option>
            @endforeach
        </select>
    </div>
    {{-- Filtrar por Organizador --}}
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Organizador:</h6>
        <select class="form-control" wire:model='idOrganizadorPrograma'>
            <option value="%%">Todos</option>
            @foreach ($listaUsuarios as $lista)
                <option value="{{ $lista->id }}">{{ $lista->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Estado Programa:</h6>
        <select class="form-control" wire:model='estadoPrograma'>
            <option value="%%">Todos</option>
            <option value="A">Activo</option>
            <option value="C">Cancelado</option>
        </select>
    </div>
</div>
@include('componentes.paginador')
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
                <th>Acción</th>
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

                    <td><button class="btn btn-primary" wire:click='verPrograma({{ $dato->idPrograma }})'>Ver</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
</div>
