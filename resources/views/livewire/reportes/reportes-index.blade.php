<div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <h6>Tipo Reporte</h6>
                            <select class="form-control" wire:model='tipoReporte'>
                                <option value="0">Seleccione...</option>
                                <option value="1">Asistencia</option>
                                <option value="2">Cronogramas</option>
                                <option value="3">Cumpleaños</option>
                                <option value="4">Membrecía</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <h6>Fecha desde</h6>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <h6>Fecha hasta</h6>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="width: 30%">
                            {{-- Opciones de búsqueda --}}
                            @include('componentes.buscador')
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <button class="btn btn-primary btn-sm">Consultar</button>
                        <a class="btn btn-primary btn-sm {{!isset($data) ? 'disabled' : '' }}"
                            href="{{ url('repor/pdf' . '/' . $idUsuario . '/' . $tipoReporte . '/' . $fechaDesde . '/' . $fechaHasta) }}"
                            target="_blank">Generar PDF</a>
                        <a class="btn btn-primary btn-sm {{ !isset($data) ? 'disabled' : '' }}""
                    href=" {{ url('repor/excel' . '/' . $idUsuario . '/' . $tipoReporte . '/' . $fechaDesde . '/' . $fechaHasta) }}"
                            target="_blank">Exportar a Excel</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            @if ($tipoReporte == 4)
                                @include('livewire.reportes.asistencia')
                                @include('livewire.reportes.ver-miembro')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
