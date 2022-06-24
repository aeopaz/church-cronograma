<div>
    {{-- Opciones de búsqueda --}}
    @include('componentes.buscador')
    <x-adminlte-button label="Crear Tipo Programa" theme="primary" wire:click='create' /> <br>
    @include('componentes.paginador')
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th wire:click='ordenar("id")'>ID
                    @if ($columna == 'id')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("nombre")'>Nombre
                    @if ($columna == 'nombre')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th>
                    Opciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tiposPrograma as $tipo)
                <tr>
                    <td>{{ $tipo->id }}</td>
                    <td>{{ $tipo->nombre }}</td>
                    <td colspan="2">
                        <x-adminlte-button theme="primary" icon="fas fa-edit" wire:click='edit({{ $tipo->id }})' />
                        <x-adminlte-button theme="danger" icon="fas fa-trash"
                            wire:click='delete({{ $tipo->id }})' wire:loading.remove wire:target='delete' />
                            <div wire:loading wire:target='delete'>
                                @include('componentes.carga')
                                </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tiposPrograma->links() }}
    @include('livewire.parametrizacion.tipos-programas.create')
    @include('livewire.parametrizacion.tipos-programas.edit')
    @include('livewire.parametrizacion.tipos-programas.delete')
</div>
