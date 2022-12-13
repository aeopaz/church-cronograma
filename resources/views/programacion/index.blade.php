@extends('adminlte::page')
@section('plugins.FullCalendar', true)

@section('title', 'Mis Programas')
{{-- Validar si se recibe variable tipoPrograma --}}
@php
    if (isset($tipoPrograma)) {
        $nombrePrograma = App\Models\TipoProgramacion::find($tipoPrograma)->nombre;
    } else {
        $tipoPrograma = null;
        $nombrePrograma='Todos';
    }
@endphp
@section('content_header')
    <h1>Eventos {{ $tipoAgenda }}. Programas {{ $nombrePrograma }}</h1>
@stop

@section('content')

    @livewire('programacion.programacion-index', ['tipoAgenda' => $tipoAgenda, 'tipoPrograma' => $tipoPrograma])
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
