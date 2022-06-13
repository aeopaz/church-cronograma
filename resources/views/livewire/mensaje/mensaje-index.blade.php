<div>
    <div class="container">
        @livewire('mensaje.mensaje-create')
        <input type="text" class="form-control mt-1" placeholder="Buscar" wire:model='buscar'>
        <table class="table table-hover table-responsive">
            <thead>
                <tr>
                    <th wire:click='ordenar("titulo")'>Título</th>
                    <th wire:click='ordenar("cuerpo")'>Mensaje</th>
                    <th wire:click='ordenar("cita")'>Cita</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mensajes as $mensaje)
                    <tr>
                        <td>{{ $mensaje->titulo }}</td>
                        <td>{{ $mensaje->cuerpo }}</td>
                        <td>{{ $mensaje->cita }}</td>
                        <td><button class="btn btn-primary" wire:click='editar_mensaje({{ $mensaje }})'>Editar</button></th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @livewire('mensaje.mensaje-edit')
</div>