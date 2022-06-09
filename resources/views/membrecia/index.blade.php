@extends('adminlte::page')

@section('title', 'Membrecía')

@section('css')

@stop

@section('content_header')
    <h1>Membrecía</h1>
@stop

@section('content')
    @livewire('membrecia.membrecia-index')
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
