<div>
    @include('componentes.buscador')
    <x-adminlte-button label="Crear Iglesia" theme="primary" wire:click='create' /> <br>
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
                <th wire:click='ordenar("direccion")'>Dirección
                    @if ($columna == 'direccion')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("telefono")'>Teléfono
                    @if ($columna == 'telefono')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("email")'>E-mail
                    @if ($columna == 'email')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($iglesias as $iglesia)
                <tr>
                    <td>{{ $iglesia->id }}</td>
                    <td>{{ $iglesia->nombre }}</td>
                    <td>{{ $iglesia->direccion }}</td>
                    <td>{{ $iglesia->telefono }}</td>
                    <td>{{ $iglesia->email }}</td>
                    <td colspan="2">
                        <x-adminlte-button theme="primary" icon="fas fa-edit" wire:click='edit({{ $iglesia }})' />
                        <x-adminlte-button theme="danger" icon="fas fa-trash" wire:click='delete({{ $iglesia }})'
                            wire:loading.remove wire:target='delete' />
                        <div wire:loading wire:target='delete'>
                            @include('componentes.carga')
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $iglesias->links() }}
    @include('livewire.iglesia.create')
    @include('livewire.iglesia.edit')
    @include('livewire.iglesia.delete')
</div>
