<div>
    {{-- Opciones de búsqueda --}}
    @include('componentes.buscador')
    <!-- <x-adminlte-button label="Crear Usuario" theme="primary" wire:click='create' /> <br> -->
    @include('componentes.paginador')
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th wire:click='ordenar("users.id")'>ID
                    @if ($columna == 'users.id')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("users.name")'>Nombre
                    @if ($columna == 'users.name')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("users.email")'>Email
                    @if ($columna == 'users.email')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("users.celular")'>Celular
                    @if ($columna == 'users.celular')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("users.estado")'>Estado
                    @if ($columna == 'users.estado')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th>Opciones</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->celular }}</td>
                    <td>
                     @canany(['admin', 'lider'])
                            <input type="checkbox" name="" id="" wire:click='estadoUsuario({{ $usuario->id }})'
                                {{ $usuario->estado == 'A' ? 'checked' : '' }}>
                        @endcanany
                        {{ $usuario->estado == 'A' ? 'Activo' : 'Inactivo' }}

                    </td>
                    <td colspan="2">
                        <x-adminlte-button theme="primary" icon="fas fa-edit" wire:click='edit({{ $usuario->id }})' />
                        @can('admin')
                            <x-adminlte-button theme="danger" icon="fas fa-trash"
                                wire:click='delete({{ $usuario->id }})'  wire:loading.remove
                                wire:target='delete' />
                                <div wire:loading wire:target='delete'>
                                    @include('componentes.carga')
                                </div>
                        @endcan
                    
                   
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $usuarios->links() }}
    @include('livewire.usuario.edit')
    @include('livewire.usuario.delete')
</div>
