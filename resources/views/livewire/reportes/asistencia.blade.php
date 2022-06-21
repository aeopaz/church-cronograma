<div class="form-group row">
    {{-- Filtrar por categoria --}}
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Categoría:</h6>
        <select class="form-control" wire:model='edad'>
            <option value="0|200">Todos</option>
            @foreach ($listaCategoria as $key => $value)
                <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Tipo Miembro:</h6>
        <select class="form-control" wire:model='tipoMiembro'>
            <option value="0|2000">Todos</option>
            <option value="4|2000">Antiguos</option>
            <option value="0|4">Nuevos</option>
        </select>
    </div>
    {{-- Filtrar por sexo --}}
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h6>Sexo:</h6>
        <input type="radio" name="sexo" wire:click='$set("tipoSexo","")'>Ambos
        <input type="radio" name="sexo" wire:click='$set("tipoSexo","F")'>Mujer
        <input type="radio" name="sexo" wire:click='$set("tipoSexo","M")'>Hombre
    </div>
</div>

{{-- Resumen por Categoria --}}
<div class="row div-centrar-tabla">
    <table class="table table-sm table-hover centrar-tabla table-responsive">
        <thead>
            <tr>
                <th>Bebé</th>
                <th>Niño</th>
                <th>Adolescente</th>
                <th>Joven</th>
                <th>Joven Adulto</th>
                <th>Adulto</th>
                <th>Adulto Mayor</th>
                <th>Anciano</th>
                <th>Longevo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $totales['value'][0] }}</td>
                <td>{{ $totales['value'][1] }}</td>
                <td>{{ $totales['value'][2] }}</td>
                <td>{{ $totales['value'][3] }}</td>
                <td>{{ $totales['value'][4] }}</td>
                <td>{{ $totales['value'][5] }}</td>
                <td>{{ $totales['value'][6] }}</td>
                <td>{{ $totales['value'][7] }}</td>
                <td>{{ $totales['value'][8] }}</td>
            </tr>
        </tbody>
    </table>
</div>
@include('componentes.paginador')
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
                <th>Acción</th>
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
                    <td>{{ $dato->nombreultimolugar }}</td>
                    <td>{{ $dato->nombreultimoprograma }}</td>
                    <td><button class="btn btn-primary" wire:click='verMiembro({{ $dato->idMiembro }})'>Ver</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
</div>
