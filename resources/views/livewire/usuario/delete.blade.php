<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               ¿Realmente desea eliminar a {{ $nombre }}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" wire:click='destroy' wire:loading.remove wire:target='destroy'>Eliminar</button>
                <div wire:loading wire:target='destroy'>
                    @include('componentes.carga')
                </div>
            </div>
        </div>
    </div>
</div>
