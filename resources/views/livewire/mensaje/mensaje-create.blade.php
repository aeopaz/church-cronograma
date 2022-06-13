<div>
    <button class="btn btn-primary" wire:click='create_mensaje'>Crear Nueva Cita</button>
    <!-- Modal -->
    <div class="modal fade" id="crearMensajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        {{ $titulo }}
                        <label for="" class="col-md-4 col-form-label text-md-right">Título</label>
                        <div class="col-md-6">
                            <input class="form-control @error ('titulo') is-invalid @enderror" wire:model.defer='titulo'>
                            @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right">Cuerpo</label>
                        <div class="col-md-6">
                            <textarea name="" id="" cols="30" rows="5" class="form-control @error ('cuerpo') is-invalid @enderror" wire:model.defer='cuerpo'></textarea>
                            @error('cuerpo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right">Cita</label>
                        <div class="col-md-6">
                            <input class="form-control @error ('cita') is-invalid @enderror" wire:model.defer='cita'>
                            @error('cita')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click='store_mensaje' wire:loading.remove wire:target='store_mensaje' >Crear</button>
                    <div wire:loading wire:target='store_mensaje'>Guardando...</div>
                </div>
            </div>
        </div>
    </div>
</div>