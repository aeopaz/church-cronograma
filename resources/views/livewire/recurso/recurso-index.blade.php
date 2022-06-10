<div>
    {{-- Opciones de búsqueda --}}
    @include('componentes.buscador')
    @canany(['admin','lider'])
        <x-adminlte-button label="Crear Recurso" theme="primary" wire:click='create' /> <br>
    @endcanany

    @include('componentes.paginador')
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th wire:click='ordenar("recurso.id")'>ID
                    @if ($columna == 'recurso.id')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("recurso.nombre")'>Nombre
                    @if ($columna == 'recurso.nombre')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("tipo_recursos.nombre")'>Tipo Recurso
                    @if ($columna == 'tipo_recursos.nombre')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recursos as $recurso)
                <tr>
                    <td>{{ $recurso->idRecurso }}</td>
                    <td>{{ $recurso->nombreRecurso }}</td>
                    <td>{{ $recurso->nombreTipoRecurso }}</td>
                    <td colspan="2">

                        <x-adminlte-button theme="primary" icon="fas fa-eye"
                            wire:click='edit({{ $recurso->idRecurso }})' />

                        @can('admin')
                            <x-adminlte-button theme="danger" icon="fas fa-trash"
                                wire:click='delete({{ $recurso->idRecurso }})' />
                        @endcan

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $recursos->links() }}
    @include('livewire.recurso.create')
    @include('livewire.recurso.edit')
    @include('livewire.recurso.delete')
</div>
