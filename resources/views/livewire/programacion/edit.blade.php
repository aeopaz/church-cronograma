<div class="modal fade" id="editarProgramaModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Programa</h5>
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
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $pestana == 'programa' ? 'active' : '' }}" id="pills-home-tab"
                            data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
                            aria-selected="true">Programa</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $pestana == 'participante' ? 'active' : '' }}" id="pills-profile-tab"
                            data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Participantes</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $pestana == 'recurso' ? 'active' : '' }}" id="pills-contact-tab"
                            data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact"
                            aria-selected="false">Recursos</a>
                    </li>
                    {{-- Permiso para ver pestaña asistencia --}}
                    @canany(['admin', 'lider'])
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $pestana == 'asistencia' ? 'active' : '' }}" id="pills-asistencia-tab"
                                data-toggle="pill" href="#pills-asistencia" role="tab" aria-controls="pills-asistencia"
                                aria-selected="false">Asistencia</a>
                        </li>
                    @endcanany

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    {{-- Programa --}}
                    <div class="tab-pane fade {{ $pestana == 'programa' ? 'show active' : '' }}" id="pills-home"
                        role="tabpanel" aria-labelledby="pills-home-tab">
                        {{-- Tipo Programa --}}
                        <div class="input-group mb-3">
                            <select name="" id=""
                                class="form-control @error('idTipoPrograma') is-invalid @enderror"
                                wire:model='idTipoPrograma'>
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
                                class="form-control @error('nombrePrograma') is-invalid @enderror"
                                wire:model='nombrePrograma' placeholder="Nombre Programa">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span
                                        class="fas fa-indent   {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
                                    <span
                                        class="fas fa-building   {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
                                    <span
                                        class="fas fa-calendar {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
                                    <span
                                        class="fas fa-calendar {{ config('adminlte.classes_auth_icon', '') }}"></span>
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
                                class="form-control @error('horaPrograma') is-invalid @enderror"
                                wire:model='horaPrograma'>

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
                                class="form-control @error('nivelPrograma') is-invalid @enderror"
                                wire:model='nivelPrograma'>
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
                        {{-- Estado Programa --}}
                        <div class="input-group mb-3">
                            <select name="" id=""
                                class="form-control @error('estadoPrograma') is-invalid @enderror"
                                wire:model='estadoPrograma'>
                                <option value="">Seleccione</option>
                                <option value="A">Activo</option>
                                <option value="C">Cancelado</option>

                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span
                                        class="fas fa-indent   {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                </div>
                            </div>

                            @error('estadoPrograma')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- Solo podrá actualizar el programa si es un admin o si el programa es propio --}}
                        @if (Auth::user()->can('lider') && Auth::user()->can('programa-update',$idPrograma))
                            <div class="row justify-content-center">
                                <button type="button" class="btn btn-primary"
                                    wire:click='update({{ $idPrograma }})' wire:loading.remove
                                    wire:target='update'>Guardar</button>
                                <div wire:loading wire:target='update'>
                                    @include('componentes.carga')
                                </div>
                            </div>
                        @endif
                        @if (Auth::user()->can('admin'))
                            <div class="row justify-content-center">
                                <button type="button" class="btn btn-primary"
                                    wire:click='update({{ $idPrograma }})' wire:loading.remove
                                    wire:target='update'>Guardar</button>
                                <div wire:loading wire:target='update'>
                                    @include('componentes.carga')
                                </div>
                            </div>
                        @endif



                    </div>
                    {{-- Lista de participantes --}}
                    <div class="tab-pane fade {{ $pestana == 'participante' ? 'show active' : '' }}"
                        id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div id="listaParticipantes" @if (!$mostrarListaParticipantes) hidden @endif>
                            <div class="row div-centrar-tabla">
                                <table class="table table-hover table-sm centrar-tabla">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Foto</th>
                                            <th>Nombre</th>
                                            <th>Rol</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($participantes as $index => $participante)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($participante->avatar == '')
                                                        <div class="row justify-content-center">
                                                            {{-- <img src="{{App\Models\User::find($participante->idUserParticipante)->url_avatar}}"
                                                            alt="" class="rounded-circle"
                                                            style="width: 30%; height: 10%;"> --}}
                                                            <div class="avatar_pequeno">
                                                                {{ App\Models\User::find($participante->idUserParticipante)->iniciales_nombre }}
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img src="{{ asset($participante->avatar) }}" alt=""
                                                            class="rounded-circle" style="width: 30%; height: 10%;">
                                                    @endif
                                                </td>
                                                <td>{{ $participante->nombreParticipante }}</td>
                                                <td>{{ $participante->nombreRol }}</td>
                                                <td>
                                                    {{-- Solo puede eliminar participantes si es admin o lider --}}
                                                    @canany(['admin', 'lider'])
                                                        <button class="btn btn-sm btn-danger" {{$participante->rol_id==19?'disabled':''}}
                                                            wire:click='eliminarParticipante({{ $participante->idParticipacion }})'
                                                            wire:loading.remove wire:target='eliminarParticipante'><i
                                                                class="fa fa-trash" aria-hidden="true"></i></button>
                                                        <div wire:loading wire:target='eliminarParticipante'>
                                                            @include('componentes.carga')
                                                        </div>
                                                    </td>
                                                @endcanany
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- @foreach ($participantes as $participante)
                                <div class="info-box bg-gradient-primary">
                                    <span class="info-box-icon"><img src="{{ asset($participante->avatar) }}" alt=""
                                            class="rounded-circle"></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $participante->nombreParticipante }}</span>
                                        <span class="info-box-number">{{ $participante->nombreRol }}</span>
                                        @if ($tipoVista == 'propia')
                                            <button class="btn btn-danger btn-sm" style="width: 20%"
                                                wire:click='eliminarParticipante({{ $participante->idParticipacion }})'>Eliminar</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach --}}
                            {{-- Solo puede agregar participantes si es admin o lider --}}
                            @canany(['admin', 'lider'])
                                {{-- Boton mostrar form participante --}}
                                <div class="row justify-content-center">
                                    <button class="btn btn-secondary float-md-right"
                                        wire:click="camposAgregarParticipantes">Adicionar
                                        Participante</button>
                                </div>
                            @endcanany
                        </div>
                        {{-- Solo puede agregar participantes si es admin o lider --}}
                        @canany(['admin', 'lider'])
                            {{-- Agregar participantes programa --}}
                            <div id="formAgregarParticipante" @if ($mostrarListaParticipantes) hidden @endif>
                                {{-- Lista Ministerios --}}
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            Ministerio
                                        </div>
                                    </div>
                                    <select name="" id=""
                                        class="form-control @error('idMinisterio') is-invalid @enderror"
                                        wire:model='idMinisterio'>
                                        <option value="">Seleccione...</option>
                                        @foreach ($listaMinisterios as $ministerio)
                                            <option value="{{ $ministerio->id }}">{{ $ministerio->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idMinisterio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- Lista Usuarios por ministerio --}}
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            Participante
                                        </div>
                                    </div>
                                    <select name="" id=""
                                        class="form-control @error('idUsuarioParticipante') is-invalid @enderror"
                                        wire:model.defer='idUsuarioParticipante'>
                                        <option value="">Seleccione...</option>
                                        @foreach ($usuariosMinisterio as $usuario)
                                            <option value="{{ $usuario->idUsuario }}">
                                                {{ $usuario->nombreUsuario }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idUsuarioParticipante')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- Lista de Roles --}}
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            Rol
                                        </div>
                                    </div>
                                    <select name="" id=""
                                        class="form-control @error('idRol') is-invalid @enderror"
                                        wire:model.defer='idRol'>
                                        <option value="">Seleccione...</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('idRol')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn btn-primary mr-2" wire:click='agregarParticipantes'
                                        wire:loading.remove wire:target='agregarParticipantes'>Agregar
                                        Participante</button>
                                    <div wire:loading wire:target='agregarParticipantes'>
                                        @include('componentes.carga')
                                    </div>
                                    {{-- Boton ocultar form participante --}}
                                    <button class="btn btn-secondary"
                                        wire:click="$set('mostrarListaParticipantes',true)">Cancelar</button>
                                </div>
                            </div>
                        @endcanany
                    </div>
                    {{-- Lista de Recursos --}}
                    {{-- @if (!isset($recurso->url))  wire:click='verRecurso({{$recurso->url}})' @endif --}}
                    <div class="tab-pane fade {{ $pestana == 'recurso' ? 'show active' : '' }} " id="pills-contact"
                        role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div @if (!$mostrarListaRecursos) hidden @endif>
                            <div class="row div-centrar-tabla">
                                <table class="table table-hover table-sm centrar-tabla">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            {{-- <th>Foto</th> --}}
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recursosPrograma as $index => $recurso)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                {{-- <td class="puntero"
                                                wire:click='verRecurso({{ $recurso->recurso_id }})'><img src="{{ asset($recurso->url) }}" alt=""
                                                        class="rounded-circle" style="width: 30%; height: 10%;"> --}}
                                                </td>
                                                <td class="puntero"
                                                    wire:click='verRecurso({{ $recurso->recurso_id }})'>
                                                    {{ $recurso->nombreRecurso }}</td>
                                                <td>{{ $recurso->tipoRecurso }}</td>
                                                <td>
                                                    {{-- Solo puede Eliminar recursos si es admin o lider --}}
                                                    @canany(['admin', 'lider'])
                                                        <button class="btn btn-sm btn-danger"
                                                            wire:click='eliminarRecursoPrograma({{ $recurso->idRecursoPrograma }})'
                                                            wire:loading.remove wire:target='eliminarRecursoPrograma'><i
                                                                class="fa fa-trash" aria-hidden="true"></i></button>
                                                        <div wire:loading wire:target='eliminarRecursoPrograma'>
                                                            @include('componentes.carga')
                                                        </div>
                                                    @endcanany
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- @foreach ($recursosPrograma as $recurso)
                                <div class="puntero info-box bg-gradient-success"
                                    wire:click='verRecurso({{ $recurso->recurso_id }})'>
                                    <span class="info-box-icon"><img src="{{ asset($recurso->url) }}" alt=""
                                            class="rounded-circle"></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $recurso->nombreRecurso }}</span>
                                        <span class="info-box-number">{{ $recurso->tipoRecurso }}</span>
                                        @if ($tipoVista == 'propia')
                                            <button class="btn btn-danger btn-sm" style="width: 20%"
                                                wire:click='eliminarRecursoPrograma({{ $recurso->idRecursoPrograma }})'>Eliminar</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach --}}
                            {{-- Solo puede Agregar recursos si es admin o lider --}}
                            @canany(['admin', 'lider'])
                                <div class="row justify-content-center">
                                    <button class="btn btn-secondary float-md-right"
                                        wire:click="camposAgregarRecurso">Agregar Recurso</button>
                                </div>
                            @endcanany
                        </div>
                        {{-- Agregar recursos programa --}}
                        {{-- Solo puede Agregar recursos si es admin o lider --}}
                        @canany(['admin', 'lider'])
                            <div @if ($mostrarListaRecursos) hidden @endif>
                                {{-- Lista Ministerios --}}
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            Ministerio
                                        </div>
                                    </div>
                                    <select name="" id=""
                                        class="form-control @error('idMinisterio') is-invalid @enderror"
                                        wire:model='idMinisterio'>
                                        <option value="">Seleccione...</option>
                                        @foreach ($listaMinisterios as $ministerio)
                                            <option value="{{ $ministerio->id }}">{{ $ministerio->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idMinisterio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- Lista de Recursos --}}
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            Recurso
                                        </div>
                                    </div>
                                    <select name="" id=""
                                        class="form-control @error('idRecurso') is-invalid @enderror"
                                        wire:model.defer='idRecurso'>
                                        <option value="">Seleccione...</option>
                                        @foreach ($listaRecursos as $recurso)
                                            <option value="{{ $recurso->idRecurso }}">
                                                {{ $recurso->nombreRecurso . '-' . $recurso->nombreTipoRecurso }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idRecurso')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn btn-primary mr-2" wire:click='agregarRecursosPrograma'
                                        wire:loading.remove wire:target='agregarRecursosPrograma'>Agregar
                                        Recurso</button>
                                    <div wire:loading wire:target='agregarRecursosPrograma'>
                                        @include('componentes.carga')
                                    </div>
                                    {{-- Boton ocultar form recursos --}}
                                    <button class="btn btn-secondary"
                                        wire:click="$set('mostrarListaRecursos',true)">Cancelar</button>
                                </div>
                            </div>
                        @endcanany
                    </div>
                    {{-- Lista de Asistencia --}}
                    {{-- Solo puede Agregar asistencia si es admin o lider --}}
                    @canany(['admin', 'lider'])
                        <div class="tab-pane fade {{ $pestana == 'asistencia' ? 'show active' : '' }}"
                            id="pills-asistencia" role="tabpanel" aria-labelledby="pills-asistencia-tab">
                            {{-- Registrar Miembros --}}
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        Miembro
                                    </div>
                                </div>
                                <select name="" id=""
                                    class="form-control @error('idMiembro') is-invalid @enderror"
                                    wire:model.defer='idMiembro'>
                                    <option value="">Seleccione...</option>
                                    @foreach ($miembros as $miembro)
                                        <option value="{{ $miembro->id }}">
                                            {{ $miembro->nombre . ' ' . $miembro->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idMiembro')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- Tipo llegada --}}
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        LLegada
                                    </div>
                                </div>
                                <select name="" id=""
                                    class="form-control @error('tipoLlegada') is-invalid @enderror"
                                    wire:model.defer='tipoLlegada'>
                                    <option value="">Seleccione...</option>
                                    <option value="Puntual">Puntual</option>
                                    <option value="Retrasada">Retrasada</option>
                                    <option value="Final">Al Final</option>
                                </select>
                                @error('tipoLlegada')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row justify-content-center">
                                <button class="btn btn-primary" wire:click='registrarAsistencia' wire:loading.remove
                                    wire:target='registrarAsistencia'>Agregar
                                    Asistencia</button>
                                <div wire:loading wire:target='registrarAsistencia'>
                                    @include('componentes.carga')
                                </div>
                            </div>
                            {{-- Miembros que asistieron --}}
                            <div class="row div-centrar-tabla">
                                <table class="table table-hover table-sm centrar-tabla">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>LLegada</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($asistenciaMiembros as $index => $asistente)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $asistente->nombreMiembro . ' ' . $asistente->apellidoMiembro }}
                                                </td>
                                                <td>{{ $asistente->tipoLlegada }}</td>
                                                <td>
                                                    @can('admin')
                                                        <button class="btn btn-sm btn-danger"
                                                            wire:click='eliminarAsistencia({{ $asistente->idAsistencia }})'
                                                            wire:loading.remove wire:target='eliminarAsistencia'><i
                                                                class="fa fa-trash" aria-hidden="true"></i></button>
                                                        <div wire:loading wire:target='eliminarAsistencia'>
                                                            @include('componentes.carga')
                                                        </div>
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endcanany
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
