<div>
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6 my-3 pt-3 shadow text-center">
                {{-- Avatar usuario --}}
                @if ($foto)
                    <img src="{{ $foto->temporaryUrl() }}" class="rounded-circle" style="width: 400px; height:400px">
                @else
                    @if (!$usuario->avatar == '')
                        <img src={{ asset($usuario->avatar) }} class="rounded-circle img-fluid"
                            style="width: 400px; height:400px">
                    @else
                        {{-- <i class="fa fa-user" aria-hidden="true" style="font-size:300px"></i> --}}
                        <div class="row justify-content-center">
                            <div class="avatar_grande">{{ auth()->user()->iniciales_nombre }}</div>
                        </div>
                    @endif
                @endif
                <form action="{{ route('users.subirFoto') }}" method="POST" enctype="multipart/form-data"
                    id="form_foto">
                    @csrf
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
                        <input type="file" class="form-control" name="file">
                        @error('foto')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="btn_foto"
                                onclick="subirArchivo('form_foto')">Cambiar
                                Avatar</button>
                            @include('componentes.modal-carga')
                        </div>
                    </div>
                </form>
                {{-- Subir Avatar usuario con Livewire --}}
                {{-- <form wire:submit.prevent="subirFoto">
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
                        <input type="file" class="form-control" wire:model='foto'>
                        @error('foto')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Cambiar
                                Avatar</button>
                        </div>
                        <div wire:loading wire:target="subirFoto">Uploading...</div>
                    </div>
                </form> --}}
                {{-- Mostrar información usuario --}}
                <br>
                <h1 class="fa fa-user" aria-hidden="true">{{ $usuario->name }}</h1>
                <br>
                <h3 class="fas fa-envelope" aria-hidden="true">{{ $usuario->email }}</h3>
                <br>
                <h3 class="fas fa-phone" aria-hidden="true">{{ $usuario->celular }}</h3>
            </div>
            <div class="col-3"></div>
        </div>
        <div class="form-group row justify-content-center">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <button class="btn btn-primary" wire:click='edit()'>Actualizar Datos</button>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <button class="btn btn-primary" wire:click='editPassword()'>Cambiar Contraseña</button>
            </div>

        </div>
    </div>
    @include('livewire.usuario.edit')
    @include('livewire.usuario.edit-password')
</div>
