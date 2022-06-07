<div class="modal fade" id="editarContrasenaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h5>
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
                    {{-- Password field old --}}
                    <div class="input-group mb-3">
                        <input type="password" wire:model='oldPassword'
                            class="form-control @error('oldPassword') is-invalid @enderror"
                            placeholder="Contraseña anterior">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                        @error('oldPassword')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- Password field new --}}
                    <div class="input-group mb-3">
                        <input type="password" wire:model='newPassword'
                            class="form-control @error('newPassword') is-invalid @enderror"
                            placeholder="Nueva Contraseña">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                        @error('newPassword')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Confirm password field --}}
                    <div class="input-group mb-3">
                        <input type="password" name="newPassword_confirmation" wire:model='newPassword_confirmation'
                            class="form-control @error('newPassword_confirmation') is-invalid @enderror"
                            placeholder="Confirmar nueva contraseña">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                        @error('newPassword_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click='updatePassword' wire:loading.remove wire:target='updatePassword'>Guardar</button>
                <div wire:loading wire:target='updatePassword'>
                    @include('componentes.carga')
                </div>

            </div>
        </div>
    </div>
    {{-- wire:click='update({{ $idUsuario }})' --}}
</div>
