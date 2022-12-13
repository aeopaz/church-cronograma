<div class="modal fade" id="crearTipoProgramaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Tipo Programa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">Nombre Tipo</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model='nombre'>
                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Color</label>
                <select class="form-control @error('color') is-invalid @enderror" wire:model='color'>
                    <option value="">Seleccione...</option>
                    @foreach ($colorArray as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('color')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click='store' wire:loading.remove
                    wire:target='store'>Guardar</button>
                <div wire:loading wire:target='store'>
                    @include('componentes.carga')
                </div>
            </div>
        </div>
    </div>
</div>
