<div>
    <x-adminlte-button label="Crear Iglesia" theme="primary" wire:click='create'/> <br>
    @include('componentes.paginador')
    <table class="table table-hover">
        <thead>
            <tr>
                <th wire:click='ordenar("id")'>ID</th>
                <th wire:click='ordenar("nombre")'>Nombre</th>
                <th wire:click='ordenar("direccion")'>Dirección</th>
                <th wire:click='ordenar("telefono")'>E-mail</th>
                <th wire:click='ordenar("email")'>E-mail</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($iglesias as $iglesia )
                <tr>
                    <td>{{ $iglesia->id }}</td>
                    <td>{{ $iglesia->nombre }}</td>
                    <td>{{ $iglesia->direccion }}</td>
                    <td>{{ $iglesia->telefono }}</td>
                    <td>{{ $iglesia->email }}</td>
                    <td colspan="2">
                        <x-adminlte-button  theme="primary" icon="fas fa-edit" wire:click='edit({{ $iglesia }})'/>
                        <x-adminlte-button theme="danger" icon="fas fa-trash" wire:click='delete({{ $iglesia }})' />
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
