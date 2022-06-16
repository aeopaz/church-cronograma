<div class="modal fade" id="crearMinisterioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Ministerio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="">Nombre Ministerio</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model='nombre'>
                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Iglesia</label>
                <select name="" id="" class="form-control @error('iglesia_id') is-invalid @enderror"
                    wire:model='iglesia_id'>
                    <option value="">Seleccione...</option>
                    @foreach ($iglesias as $iglesia)
                        <option value="{{ $iglesia->id }}" {{-- {{ $iglesia->id==Auth::user()->id?"selected":"" }} --}}>{{ $iglesia->nombre }}</option>
                    @endforeach
                </select>
                @error('iglesia_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="">Líder</label>
                <select name="" id="" class="form-control @error('user_id') is-invalid @enderror" wire:model='user_id'>
                    <option value="">Seleccione...</option>
                    @foreach ($lideres as $lider)
                        <option value="{{ $lider->id }}">{{ $lider->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
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
