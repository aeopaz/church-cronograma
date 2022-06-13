@extends('adminlte::page')

@section('title', 'Mensaje')

@section('content_header')
    <h1>Mensajes</h1>
@stop

@section('content')
    @livewire('mensaje.mensaje-index')
@stop

@section('css')

@stop

@section('js')
{{-- Escucha el evento 'modal' y ejecuta el script--}}
<script type="text/javascript">
    window.livewire.on('modal',(nombreModal,propiedad)=>{
        $('#'+nombreModal).modal(propiedad);

    });
</script>
@stop