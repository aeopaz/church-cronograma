<style>
    .centrar-img {

        width: 100px;
        height: 110px;


    }

    .logo {
        text-align: center;
    }

    .titulo {
        text-align: center;
        margin: 0px
    }

 

    thead {
        background-color: rgb(0, 183, 255);
    }

    table,
    td,
    th {
        border-color: gray;
        border-width: 1px;
        border-style: solid;
        border-collapse: collapse;
        margin: 0 auto;
        text-align: center;

    }
    .seccion{
        margin-bottom: 20px;
    }
</style>
<div class="logo">
    <img class="centrar-img" src="{{ 'vendor\adminlte\dist\img\logoIglesia.png' }}" alt="">
</div>

<h1 class="titulo">Iglesia Bautista Jehova Reina</h1>
<h2 class="titulo">{{ $nombreReporte }}</h2>
<h2 class="titulo">Fecha: {{ $fechaInicial." a ".$fechaFinal }}</h2>
