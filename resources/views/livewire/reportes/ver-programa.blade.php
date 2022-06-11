<div class="modal fade" id="verProgramaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalle Programa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($datosPrograma)
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-sm-12">
                            <label for="">Tipo Programa</label>
                            <div>{{ $datosPrograma->tipoPrograma }}</div>
                        </div>

                        <div class="col-xl-3 col-md-6 col-sm-12">
                            <label for="">Nombre</label>
                            <div>{{ $datosPrograma->nombrePrograma }}</div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-12">
                            <label for="">Lugar</label>
                            <div>{{ $datosPrograma->nombreLugar }}</div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-12">
                            <label for="">Organizador</label>
                            <div>{{ $datosPrograma->nombreOrganizador }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="">Fecha y Hora</label>
                            <div>{{ $datosPrograma->fecha . ' ' . $datosPrograma->hora }}</div>
                        </div>
                    </div>
                @endif
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">Asistencia</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                            role="tab" aria-controls="pills-profile" aria-selected="false">Participantes</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        @if ($datosAsistentes)
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>LLegada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datosAsistentes as $asistente)
                                        <tr>
                                            <td>{{ $asistente->nombreMiembro . ' ' . $asistente->apellidoMiembro }}
                                            </td>
                                            <td>{{ $asistente->tipoMiembro }}</td>
                                            <td>{{ $asistente->tipoLlegada }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            No hay registros de asistentes
                        @endif

                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        @if ($datosParticipantes)
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Rol</th>
                                    <th>Ministerio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datosParticipantes as $participante)
                                    <tr>
                                        <td>{{ $participante->nombreParticipante}}
                                        </td>
                                        <td>{{ $participante->nombreRol }}</td>
                                        <td>{{ $participante->nombreMinisterio }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        No hay registros de asistentes
                    @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
