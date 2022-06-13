<div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    {{-- Mensaje Error --}}
                    @if (session()->has('fail'))
                        <div class="alert alert-danger">
                            {{ session('fail') }}
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <h6>Tipo Reporte</h6>
                            <select class="form-control" wire:model='tipoReporte'>
                                <option value="0">Seleccione...</option>
                                <option value="1">Actividades/Programas</option>
                                <option value="2">Cronogramas</option>
                                <option value="3">Cumpleaños</option>
                                <option value="4">Membrecía</option>
                                <option value="5">Recurso</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <h6>Fecha desde</h6>
                            <input type="date" class="form-control" wire:model='fechaDesde'>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <h6>Fecha hasta</h6>
                            <input type="date" class="form-control" wire:model='fechaHasta'>
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
                        <a class="btn btn-primary btn-sm {{ !isset($data) ? 'disabled' : '' }}"
                            href="{{ url('repor/pdf' . '/' . $idUsuarioLogueado . '/' . $tipoReporte . '/' . $fechaDesde . '/' . $fechaHasta) }}"
                            target="_blank">Generar PDF</a>
                        <a class="btn btn-primary btn-sm {{ !isset($data) ? 'disabled' : '' }}"
                    href=" {{ url('repor/excel' . '/' . $idUsuarioLogueado . '/' . $tipoReporte . '/' . $fechaDesde . '/' . $fechaHasta) }}"
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
                            @if ($tipoReporte == 1)
                                @include('livewire.reportes.programas')
                                @include('livewire.reportes.ver-programa')
                            @endif
                            @if ($tipoReporte == 2)
                                @include('livewire.reportes.cronograma')
                                @include('livewire.reportes.ver-programa')
                            @endif
                            @if ($tipoReporte == 3)
                                @include('livewire.reportes.cumpleanos')
                                @include('livewire.reportes.ver-miembro')
                            @endif
                            @if ($tipoReporte == 4)
                                @include('livewire.reportes.asistencia')
                                @include('livewire.reportes.ver-miembro')
                            @endif
                            @if ($tipoReporte == 5)
                                @include('livewire.reportes.recurso')
                                @include('livewire.reportes.ver-recurso')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
