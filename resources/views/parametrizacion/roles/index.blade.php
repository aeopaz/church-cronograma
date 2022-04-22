@extends('adminlte::page')

@section('title', 'Roles')

@section('css')

@stop

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')
@livewire('parametrizacion.roles.roles-index')
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
