@extends('adminlte::page')
@section('plugins.Chartjs', false)

@section('title', 'Programación General')

@section('css')

@stop

@section('content_header')
    <h1>Panel Informativo</h1>
@stop

@section('content')
    @livewire('panel.panel-index', ['tipoVista' => 'general'])
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });

    </script>
@stop
