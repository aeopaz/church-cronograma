<div class="modal fade" id="verRecursoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Recurso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Archivo --}}
                <div class="row justify-content-center">
                    @if ($datosRecurso != '')
                        <h6>{{ $datosRecurso->nombre }}</h6>
                        @if (!$datosRecurso->url == '')
                            <img src={{ asset($datosRecurso->url) }} class="img-fluid"
                                style="width: 100%; height:100%">
                        @else
                            <i class="fa fa-file" aria-hidden="true" style="font-size:200px"></i>
                        @endif
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
