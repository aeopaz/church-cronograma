@extends('adminlte::page')

@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@stop

@section('content_header')
    <h1>Inicio</h1>
@stop

@section('content')
    {{-- Textos Bíblicos --}}
    <div class="row justify-content-center">
        <h3>Píldora Bíblica</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><b><em> {{ $mensajesBiblicos->titulo }}</em></b></div>
                <div class="card-body">
                    <em> {{ $mensajesBiblicos->cuerpo }}</em>
                </div>
                <div class="text-center">
                    <b><em> {{ $mensajesBiblicos->cita }}</em></b>
                </div>

            </div>
        </div>
    </div>
    {{-- Notificaciones --}}
    @if (count($notificaciones) > 0)
        <div class="row justify-content-center">
            <h3>Notificaciones</h3>
            @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {{ Session::get('fail') }}
                </div>
            @endif
        </div>
        <div class="row justify-content-center">
            @foreach ($notificaciones as $notificacion)
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-calendar"></i></span>
                    <div class="info-box-content">
                        @foreach ($notificacion->data as $key => $value)
                            <span class="info-box-number m-0">{{ $key }}: {{ $value }}</span>
                        @endforeach
                        <span class="info-box-text">{{ $notificacion->created_at->diffForHumans() }}</span>
                        <form action="{{ route('home.marcarNotificacionLeida', $notificacion) }}" method="post">
                            @csrf
                            <span class="info-box-text"><button class="btn btn-primary btn-sm">Marcar como
                                    leída</button></span>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    {{-- Cumpleañeros --}}
    @if (count($cumpleaneros) > 0)
        <div class="row justify-content-center bg-success">
            <h3>Felicitamos a los siguientes hermanos que cumplen años en el mes de
                {{ Carbon\Carbon::now()->format('F') }}:
            </h3>
        </div>
        <div class="row justify-content-center">
            @foreach ($cumpleaneros as $cumple)
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="material-symbols-outlined">cake</i></span>
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
