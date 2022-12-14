<div class="modal fade" id="crearProgramaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Programa</h5>
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

                {{-- Tipo Programa --}}
                <div class="input-group mb-3">
                    <select name="" id=""
                        class="form-control @error('idTipoPrograma') is-invalid @enderror" wire:model='idTipoPrograma'>
                        <option value="">Seleccione</option>
                        @foreach ($listaTipoPrograma as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-indent   {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('idTipoPrograma')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Nombre Programa --}}
                <div class="input-group mb-3">
                    <input type="text" name="nombrePrograma"
                        class="form-control @error('nombrePrograma') is-invalid @enderror" wire:model='nombrePrograma'
                        placeholder="Nombre Programa">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-indent   {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('nombrePrograma')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- Lugar Programa --}}
                <div class="input-group mb-3">
                    <select name="" id=""
                        class="form-control @error('idLugarPrograma') is-invalid @enderror"
                        wire:model='idLugarPrograma'>
                        <option value="">Seleccione</option>
                        @foreach ($listaLugares as $lugar)
                            <option value="{{ $lugar->id }}">{{ $lugar->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-building   {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('idLugarPrograma')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- Fecha Programa --}}
                <div class="input-group mb-3">
                    <input type="date" name="fechaProgramaDesde"
                        class="form-control @error('fechaProgramaDesde') is-invalid @enderror"
                        wire:model='fechaProgramaDesde'>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-calendar {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('fechaProgramaDesde')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="date" name="fechaProgramaHasta"
                        class="form-control @error('fechaProgramaHasta') is-invalid @enderror"
                        wire:model='fechaProgramaHasta'>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-calendar {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('fechaProgramaHasta')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- Hora Programa --}}
                <div class="input-group mb-3">
                    <input type="time" name="horaPrograma"
                        class="form-control @error('horaPrograma') is-invalid @enderror" wire:model='horaPrograma'>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-clock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('horaPrograma')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- Nivel de privacidad Programa --}}
                <div class="input-group mb-3">
                    <select name="" id=""
                        class="form-control @error('nivelPrograma') is-invalid @enderror" wire:model='nivelPrograma'>
                        <option value="1">Público</option>
                        <option value="2">Privado</option>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-eye   {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('nivelPrograma')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- Observaciones --}}
                <div class="input-group mb-3">
                    <textarea name="" id="" maxlength="200"
                        class="form-control @error('observaciones') is-invalid @enderror" wire:model='observaciones'>
                    </textarea>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-comment   {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('observaciones')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

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
