<div>
    <x-adminlte-button label="Crear Rol" theme="primary" wire:click='create' /> <br>
    @include('componentes.paginador')
    <table class="table table-hover">
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
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $rol)
                <tr>
                    <td>{{ $rol->id }}</td>
                    <td>{{ $rol->nombre }}</td>
                    <td colspan="2">
                        <x-adminlte-button theme="primary" icon="fas fa-edit" wire:click='edit({{ $rol->id }})' />
                        <x-adminlte-button theme="danger" icon="fas fa-trash"
                            wire:click='delete({{ $rol->id }})' />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $roles->links() }}
    @include('livewire.parametrizacion.roles.create')
    @include('livewire.parametrizacion.roles.edit')
    @include('livewire.parametrizacion.roles.delete')
</div>
