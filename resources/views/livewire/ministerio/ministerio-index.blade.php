<div>
    <x-adminlte-button label="Crear Ministerio" theme="primary" wire:click='create' /> <br>
    @include('componentes.paginador')
    <table class="table table-hover">
        <thead>
            <tr>
                <th wire:click='ordenar("ministerios.id")'>ID
                    @if ($columna == 'ministerios.id')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("ministerios.nombre")'>Nombre
                    @if ($columna == 'ministerios.nombre')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("iglesias.nombre")'>Iglesia
                    @if ($columna == 'iglesias.nombre')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("users.name")'>Líder
                    @if ($columna == 'users.name')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ministerios as $ministerio)
                <tr>
                    <td>{{ $ministerio->idMinisterio }}</td>
                    <td>{{ $ministerio->nombreMinisterio }}</td>
                    <td>{{ $ministerio->nombreIglesia }}</td>
                    <td>{{ $ministerio->nombreLider }}</td>
                    <td colspan="2">
                        <x-adminlte-button theme="primary" icon="fas fa-edit" wire:click='edit({{ $ministerio->idMinisterio }})' />
                        <x-adminlte-button theme="danger" icon="fas fa-trash"
                            wire:click='delete({{ $ministerio->idMinisterio }})' />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $ministerios->links() }}
    @include('livewire.ministerio.create')
    @include('livewire.ministerio.edit')
    @include('livewire.ministerio.delete')
</div>
