<div class="modal fade" id="verMiembroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Miembro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">Categoría</label>
                <input type="text" maxlength="10" class="form-control @error('numeroDocumento') is-invalid @enderror" wire:model='categoriaMiembro'>
                <label for="">Tipo Documento Identificación</label>
                <input type="text" maxlength="10" class="form-control @error('numeroDocumento') is-invalid @enderror" wire:model='tipoidMiembro'>
                <label for="">Número Identificación</label>
                <input type="text" maxlength="10" class="form-control @error('numeroDocumento') is-invalid @enderror" wire:model='numeroIDMiembro'>
                <label for="">Nombre</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model='nombreMiembro'>
                <label for="">Apellido</label>
                <input type="text" class="form-control @error('apellido') is-invalid @enderror" wire:model='apellidoMiembro'>
                <label for="">Fecha Nacimiento</label>
                <input type="date" class="form-control @error('fechaNacimiento') is-invalid @enderror" wire:model='fechaNacimiento'>
                <label for="">Sexo</label>
                <input type="text" maxlength="10" class="form-control @error('numeroDocumento') is-invalid @enderror" wire:model='sexo'>
                <label for="">Estado Civil</label>
                <input type="text" maxlength="10" class="form-control @error('numeroDocumento') is-invalid @enderror" wire:model='estadoCivil'>
                <label for="">Celular</label>
                <input type="number" class="form-control @error('celular') is-invalid @enderror" wire:model='celular'>
                <label for="">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model='email'>
                <label for="">Ciudad</label>
                <input type="text" maxlength="10" class="form-control @error('numeroDocumento') is-invalid @enderror" wire:model='ciudad'>
                <label for="">Barrio</label>
                <input type="email" class="form-control @error('barrio') is-invalid @enderror" wire:model='barrio'>
                <label for="">Dirección</label>
                <input type="email" class="form-control @error('direccion') is-invalid @enderror" wire:model='direccion'>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
