@extends('adminlte::page')

@section('title', 'Tipos de Programa')

@section('css')

@stop

@section('content_header')
    <h1>Tipos de Programa</h1>
@stop

@section('content')
@livewire('parametrizacion.tipos-programas.tipo-programa-index')
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
