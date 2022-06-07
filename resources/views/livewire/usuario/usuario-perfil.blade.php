<div>
    <div class="container">
        <div class="row">
            <div class="col-12 my-3 pt-3 shadow text-center">
                {{-- Avatar usuario --}}
                @if ($foto)
                    <img src="{{ $foto->temporaryUrl() }}" class="rounded-circle" style="width: 400px; height:400px">
                @else
                    @if (!$usuario->avatar == '')
                        <img src={{ asset($usuario->avatar) }} class="rounded-circle img-fluid" style="width: 400px; height:400px">
                    @else
                        <i class="fa fa-user" aria-hidden="true" style="font-size:300px"></i>
                    @endif
                @endif
                {{-- Subir Avatar usuario --}}
                <form wire:submit.prevent="subirFoto">
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
                    </div>

                </form>
                {{-- Mostrar información usuario --}}
                <br>
                <h1 class="fa fa-user" aria-hidden="true">{{ $usuario->name }}</h1>
                <br>
                <h3 class="fas fa-envelope" aria-hidden="true">{{ $usuario->email }}</h3>
                <br>
                <h3 class="fas fa-phone" aria-hidden="true">{{ $usuario->celular }}</h3>
            </div>
        </div>
        <ul class="ul">
            <li>
                <button class="btn btn-primary" wire:click='edit()'>Actualizar Datos</button>
            </li>
            <li>
                <button class="btn btn-primary" wire:click='editPassword()'>Cambiar Contraseña</button>
            </li>
        </ul>
    </div>
    @include('livewire.usuario.edit')
    @include('livewire.usuario.edit-password')
</div>
