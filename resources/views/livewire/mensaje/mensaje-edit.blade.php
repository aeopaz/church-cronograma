<div>
    <!-- Modal -->
    <div class="modal fade" id="editarMensajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right">Título</label>
                        <div class="col-md-6">
                            <input class="form-control @error ('mensaje.titulo') is-invalid @enderror" wire:model.defer='mensaje.titulo'>
                            @error('mensaje.titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right">Cuerpo</label>
                        <div class="col-md-6">
                            <textarea name="" id="" cols="30" rows="5" class="form-control @error ('mensaje.cuerpo') is-invalid @enderror" wire:model.defer='mensaje.cuerpo'></textarea>
                            @error('mensaje.cuerpo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right">Cita</label>
                        <div class="col-md-6">
                            <input class="form-control @error ('mensaje.cita') is-invalid @enderror" wire:model.defer='mensaje.cita'>
                            @error('mensaje.cita')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click='update_mensaje' wire:loading.remove wire:target='update_mensaje' >Actualizar</button>
                    <div wire:loading wire:target='update_mensaje'>Guardando...</div>
                </div>
            </div>
        </div>
    </div>
</div>