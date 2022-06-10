@extends('adminlte::page')

@section('title', 'Reportes')

@section('css')

@stop

@section('content_header')
    <h1>Reportes</h1>
@stop

@section('content')
    @livewire('reportes.reportes-index')
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
