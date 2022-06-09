<div class="modal fade" id="crearRecursoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Recurso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (session()->has('fail'))
                    <div class="alert alert-danger">
                        {{ session('fail') }}
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <label for="">Nombre Recurso</label>
                <input type="text" class="form-control @error('nombreRecurso') is-invalid @enderror"
                    wire:model='nombreRecurso'>
                @error('nombreRecurso')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Tipo Recurso</label>
                <select name="" id="" class="form-control @error('idTipoRecurso') is-invalid @enderror"
                    wire:model='idTipoRecurso'>
                    <option value="">Seleccione...</option>
                    @foreach ($listaTipoRecursos as $tipoRecurso)
                        <option value="{{ $tipoRecurso->id }}">{{ $tipoRecurso->nombre }}</option>
                    @endforeach
                </select>
                @error('idTipoRecurso')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Ministerio</label>
                <select name="" id="" class="form-control @error('idMinisterio') is-invalid @enderror"
                    wire:model='idMinisterio'>
                    <option value="">Seleccione...</option>
                    @foreach ($listaMinisterios as $ministerio)
                        <option value="{{ $ministerio->id }}">{{ $ministerio->nombre }}</option>
                    @endforeach
                </select>
                @error('idMinisterio')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click='store'>Guardar</button>
            </div>
        </div>
    </div>
</div>
