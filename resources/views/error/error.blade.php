@extends('adminlte::page')

@section('title', 'Error')

@section('css')

@stop

@section('content_header')
    <h1>Error</h1>
@stop

@section('content')
    @if (Session::get('fail'))
        <div class="alert alert-danger">
            {{ Session::get('fail') }}
        </div>
    @endif
@stop


@section('js')
    <script type="text/javascript">
        window.livewire.on('modal', (nombreModal, propiedad) => {
            $('#' + nombreModal).modal(propiedad);
        });
    </script>
@stop
