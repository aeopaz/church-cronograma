<div class="modal fade" id="crearMiembroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Miembro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">Tipo Documento Identificación</label>
                <select type="text" class="form-control @error('tipoDocumento') is-invalid @enderror"
                    wire:model='tipoDocumento'>
                    <option value="">Seleccione...</option>
                    @for ($i = 0; $i < count($tipoId['clave']); $i++)
                        <option value="{{ $tipoId['clave'][$i] }}">{{ $tipoId['valor'][$i] }}</option>
                    @endfor
                </select>
                @error('tipoDocumento')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Número Identificación</label>
                <input type="text" maxlength="10" class="form-control @error('numeroDocumento') is-invalid @enderror"
                    wire:model='numeroDocumento'>
                @error('numeroDocumento')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Nombre</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model='nombre'>
                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Apellido</label>
                <input type="text" class="form-control @error('apellido') is-invalid @enderror" wire:model='apellido'>
                @error('apellido')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Fecha Nacimiento</label>
                <input type="date" class="form-control @error('fechaNacimiento') is-invalid @enderror"
                    wire:model='fechaNacimiento'>
                @error('fechaNacimiento')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Sexo</label>
                <select type="text" class="form-control @error('sexo') is-invalid @enderror" wire:model='sexo'>
                    <option value="">Seleccione...</option>
                    @for ($i = 0; $i < count($tipoSexo['clave']); $i++)
                        <option value="{{ $tipoSexo['clave'][$i] }}">{{ $tipoSexo['valor'][$i] }}</option>
                    @endfor
                </select>
                @error('sexo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Estado Civil</label>
                <select type="text" class="form-control @error('estadoCivil') is-invalid @enderror"
                    wire:model='estadoCivil'>
                    <option value="">Seleccione...</option>
                    @for ($i = 0; $i < count($tipoEstadoCivil['clave']); $i++)
                        <option value="{{ $tipoEstadoCivil['clave'][$i] }}">{{ $tipoEstadoCivil['valor'][$i] }}
                        </option>
                    @endfor
                </select>
                @error('estadoCivil')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Celular</label>
                <input type="number" class="form-control @error('celular') is-invalid @enderror" wire:model='celular'>
                @error('celular')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model='email'>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Ciudad</label>
                <select type="text" class="form-control @error('ciudad') is-invalid @enderror" wire:model='ciudad'>
                    <option value="">Seleccione...</option>
                    @for ($i = 0; $i < count($nombreCiudad['clave']); $i++)
                        <option value="{{ $nombreCiudad['clave'][$i] }}">{{ $nombreCiudad['valor'][$i] }}</option>
                    @endfor
                </select>
                @error('ciudad')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Barrio</label>
                <input type="email" class="form-control @error('barrio') is-invalid @enderror" wire:model='barrio'>
                @error('barrio')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Dirección</label>
                <input type="email" class="form-control @error('direccion') is-invalid @enderror"
                    wire:model='direccion'>
                @error('direccion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Fecha Conversión</label>
                <input type="date" class="form-control @error('fechaConversion') is-invalid @enderror"
                    wire:model='fechaConversion'>
                @error('fechaConversion')
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
