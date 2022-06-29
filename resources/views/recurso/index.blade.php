@extends('adminlte::page')

@section('title', 'Recursos')

@section('css')

@stop

@section('content_header')
    <h1>Recursos</h1>
@stop

@section('content')
    @livewire('recurso.recurso-index')
@stop


@section('js')
    <script src="{{ asset('js/archivo.js') }}"></script>
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>

@stop
