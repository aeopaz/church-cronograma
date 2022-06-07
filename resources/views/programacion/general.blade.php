@extends('adminlte::page')

@section('title', 'Programación General')

@section('css')
    <style>
        /*
    Full screen Modal
    */
        .fullscreen-modal .modal-dialog {
            margin: 0;
            margin-right: auto;
            margin-left: auto;
            width: 100%;
        }

        @media (min-width: 768px) {
            .fullscreen-modal .modal-dialog {
                width: 750px;
            }
        }

        @media (min-width: 992px) {
            .fullscreen-modal .modal-dialog {
                width: 970px;
            }
        }

        @media (min-width: 1200px) {
            .fullscreen-modal .modal-dialog {
                width: 1170px;
            }
        }

        .redondo {
            display: block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
    </style>
@stop

@section('content_header')
    <h1>Programas Generales</h1>
@stop

@section('content')
    @livewire('programacion.programacion-index',['tipoVista'=>'general'])
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
