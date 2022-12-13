@extends('adminlte::page')

@section('title', 'Tipos de Programa')

@section('css')
    <style>
        select option[value="blue"] {
            color: blue;
        }
        select option[value="red"] {
            color: red;
        }
        select option[value="fuchsia"] {
            color: fuchsia;
        }

        select option[value="yellow"] {
            color: yellow;
            background: gray
        }

        select option[value="lime"] {
            color: lime;
        }

        select option[value="aqua"] {
            color: aqua;
        }

        select option[value="black"] {
            color: black;
        }

        select option[value="purple"] {
            color: purple;
        }

        select option[value="maroon"] {
            color: maroon;
        }

        select option[value="olive"] {
            color: olive;
        }

        select option[value="green"] {
            color: green;
        }

        select option[value="teal"] {
            color: teal;
        }
        select option[value="gray"] {
            color: gray;
        }
        select option[value="silver"] {
            color: silver;
            background: gray;
        }



       
    </style>
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
