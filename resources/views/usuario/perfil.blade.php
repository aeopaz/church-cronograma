@extends('adminlte::page')

@section('title', 'Perfil')

@section('css')

    <style>
        .ul {
            list-style: none;
            text-align: center
        }

    </style>

@stop

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')
@livewire('usuario.usuario-perfil',['tipoVista'=>'perfil'])
@stop

@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
