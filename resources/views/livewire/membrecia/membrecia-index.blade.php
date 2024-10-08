<div>
    @include('componentes.buscador')
    @canany(['admin', 'lider'])
        <x-adminlte-button label="Crear Miembro" theme="primary" wire:click='create' /> <br>
    @endcanany
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
                <th wire:click='ordenar("celular")'>Celular
                    @if ($columna == 'celular')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th wire:click='ordenar("email")'>E-mail
                    @if ($columna == 'email')
                        <div class="fa fa-sort"></div>
                    @endif
                </th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($miembros as $miembro)
                <tr>
                    <td>{{ $miembro->id }}</td>
                    <td>{{ $miembro->nombre . ' ' . $miembro->apellido }}</td>
                    <td>{{ $miembro->direccion }}</td>
                    <td>{{ $miembro->celular }}</td>
                    <td>{{ $miembro->email }}</td>
                    <td colspan="2">

                        <x-adminlte-button theme="primary" icon="fas fa-eye" wire:click='edit({{ $miembro }})' />
                        @can('admin')
                            <x-adminlte-button theme="danger" icon="fas fa-trash" wire:click='delete({{ $miembro }})'
                                wire:loading.remove wire:target='delete' />
                            <div wire:loading wire:target='delete'>
                                @include('componentes.carga')
                            </div>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $miembros->links() }}
    @include('livewire.membrecia.create')
    @include('livewire.membrecia.edit')
    @include('livewire.membrecia.delete')
</div>
