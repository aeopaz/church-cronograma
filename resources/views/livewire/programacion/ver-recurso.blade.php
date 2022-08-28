<div class="modal fade" id="verRecursoModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $nombreRecurso }}</h5>
                <button type="button" class="close" wire:click='ocultarVerRecurso' aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Archivo --}}
                <div class="row justify-content-center">
                    @if (!$imagenRecurso == '')
                        @if ($extensionRecurso == 'pdf')
                            <img src={{ asset($imagenRecurso) }} class="img-fluid" style="width: 100%; height:100%">
                        @else
                            <iframe width="400" height="400" src="{{ asset($rutaArchivo) }}"
                                frameborder="0"></iframe>{{-- Para visualizar el pdf --}}
                        @endif
                    @else
                        <i class="fa fa-file" aria-hidden="true" style="font-size:200px"></i>
                    @endif

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click='ocultarVerRecurso'>Cerrar</button>
            </div>
        </div>
    </div>
</div>
