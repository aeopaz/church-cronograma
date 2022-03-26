<div class="modal fade" id="editarIglesiaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Iglesia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">Nombre Iglesia</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                    wire:model='nombre'>
                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Direccion</label>
                <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                    wire:model='direccion'>
                    @error('direccion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Teléfono</label>
                <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                    wire:model='telefono'>
                    @error('telefono')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror"
                    wire:model='email'>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click='update({{ $idIglesia }})'>Guardar</button>
            </div>
        </div>
    </div>
</div>
