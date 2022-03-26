@extends('adminlte::page')

@section('title', 'Iglesia')

@section('css')

@stop

@section('content_header')
    <h1>Iglesia</h1>
@stop

@section('content')
    @livewire('iglesia.iglesia-index')
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
