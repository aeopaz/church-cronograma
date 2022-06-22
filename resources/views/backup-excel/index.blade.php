@extends('adminlte::page')

@section('title', 'Backup Excel')

@section('css')

@stop

@section('content_header')
    <h1>Backup Excel</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-body">
                <form action="{{ route('backup.exportar') }}" method="get">
                    <button class="btn btn-primary">Exportar DB a excel</button>
                </form>
            </div>
        </div>
    </div>
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
