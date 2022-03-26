@extends('adminlte::page')

@section('title', 'Ministerios')

@section('css')

@stop

@section('content_header')
    <h1>Ministerios</h1>
@stop

@section('content')
    @livewire('ministerio.ministerio-index')
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
