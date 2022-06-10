<div class="modal fade" id="editarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @if (session()->has('fail'))
                        <div class="alert alert-danger">
                            {{ session('fail') }}
                        </div>
                    @endif

                    {{-- Name field --}}
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            wire:model='nombre' placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Email field --}}
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            wire:model='email' placeholder="{{ __('adminlte::adminlte.email') }}">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- Celular field --}}
                    <div class="input-group mb-3">
                        <input type="number" name="celular" class="form-control @error('celular') is-invalid @enderror"
                            wire:model='celular' placeholder="Celular">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                        @error('celular')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
                @canany(['admin', 'lider'])
                    @if ($tipoVista == 'index')
                        {{-- Asociar ministerios --}}
                        <h5>Asociar Usuario a ministerios</h5>
                        <form>
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
                            @foreach ($listaMinisterios as $index => $ministerio)
                                <input type="checkbox"
                                    wire:click='asociarMinisterio({{ $idUsuario }},{{ $ministerio->id }})'
                                    @if (in_array($ministerio->id, $ministeriosUsuario)) checked @endif>{{ $ministerio->nombre }}
                                <br>
                            @endforeach
                        </form>
                    @endif
                @endcanany
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click='update({{ $idUsuario }})'
                    wire:loading.remove wire:target='update'>Guardar</button>
                <div wire:loading wire:target='update'>
                    @include('componentes.carga')
                </div>
            </div>
        </div>
    </div>
</div>
