<div class="modal fade" id="editarRecursoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Recurso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Archivo --}}
                <div class="row justify-content-center">
                    @if ($archivoTemporal)
                        <img src="{{ $archivoTemporal->temporaryUrl() }}" class="img-fluid"
                            style="width: 100%; height:100%">
                    @else
                        @if (!$archivoRecurso == '')
                            <img src={{ asset($archivoRecurso) }} class="img-fluid"
                                style="width: 100%; height:100%">
                        @else
                            <i class="fa fa-file" aria-hidden="true" style="font-size:200px"></i>
                        @endif
                    @endif
                </div>
                {{-- Subir Archivo --}}
                <form wire:submit.prevent="subirArchivo">
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
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" wire:model='archivoTemporal'>
                        @error('archivoTemporal')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Subir
                                Archivo</button>
                        </div>
                    </div>
                    <div class="row">
                        @if (!$mostrarFormEditar)
                            <button class="btn btn-secondary" wire:click="$set('mostrarFormEditar',true)">
                                Editar Recurso</button>
                        @else
                            <button class="btn btn-secondary" wire:click="$set('mostrarFormEditar',false)">
                               Cancelar</button>
                        @endif
                    </div>

                </form>
                <div @if (!$mostrarFormEditar) hidden @endif>
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
                    <button type="button" class="btn btn-primary" wire:click='update'>Actualizar</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
