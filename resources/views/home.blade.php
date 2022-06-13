@extends('adminlte::page')

@section('title', 'Dashboard')

@section('css')

@stop

@section('content_header')
    <h1>Inicio</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <h3>Píldora Bíblica</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><b><em> {{ $mensaje->titulo }}</em></b></div>
                <div class="card-body">
                    <em> {{ $mensaje->cuerpo }}</em>
                </div>
                <div class="text-center">
                    <b><em> {{ $mensaje->cita }}</em></b>
                </div>

            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <h3>Notificaciones</h3>
    </div>
    <div class="row">

    </div>
    @if (count($cumpleaneros) > 0)
        <div class="row justify-content-center">
            <h3>Felicitamos a los siguientes hermanos que cumplen años en esta semana</h3>
        </div>
        <div class="row justify-content-center">
            @foreach ($cumpleaneros as $cumple)
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-number">{{ $cumple->nombre . ' ' . $cumple->apellido }}</span>
                        <span class="info-box-text">Día: {{ $cumple->fecha_nacimiento->format('F j') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@stop


@section('js')

@stop
