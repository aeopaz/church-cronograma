@extends('adminlte::page')

@section('title', 'Usuarios')

@section('css')

@stop

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    @livewire('usuario.usuario-index')
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
