<div>
    {{-- Opciones de búsqueda --}}
    @include('componentes.buscador')
    {{-- Crear programa --}}
    @if ($tipoVista == 'propia')
        <x-adminlte-button label="Nueva Programación" theme="primary" wire:click='create' /> <br>
    @endif
   


    {{-- Primer for que recorre los años de los programas - --}}
    @if (count($anosPrograma) == 0)
        @if ($tipoVista == 'general')
            No tienes compromisos asignados
        @else
            No tienes programas creados, para crear uno, has clic en el botón "Nueva Programación"
        @endif
    @else
        @for ($i = 0; $i < count($anosPrograma); $i++)
            <h1>{{ $anosPrograma[$i] }}</h1><br>
            {{-- Segundo for que recorre los programas agrupados por años - --}}
            @for ($j = 0; $j < count($grupoxAnoxMes); $j++)
                {{-- Validar si el índice se encuentra definido en la variable - --}}
                @if (isset($grupoxAnoxMes[$j][$anosPrograma[$i]]))
                    <div class="puntero info-box @if ($grupoxAnoxMes[$j][$anosPrograma[$i]][0]['estadoPrograma'] == 'C') bg-secondary @else bg-success @endif"
                        wire:click='edit({{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['idPrograma'] }})'>
                        <span class="info-box-icon bg-light"
                            style="width: 150px">{{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['diaPrograma'] }}</span>
                        <div class="info-box-content">
                            <span class="info-box-number">
                                No. {{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['idPrograma'] }}
                                Nombre Programa:
                                {{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['nombrePrograma'] }}-Tipo:
                                {{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['nombreTipoPrograma'] }} </span>
                            <span class="info-box-text">Hora:
                                {{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['horaPrograma'] }}</span>
                            <span class="info-box-text">Organizador:
                                {{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['nombreUsuarioCreador'] }}</span>
                            <span class="info-box-text">Lugar:
                                {{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['nombreLugar'] }}</span>
                            @if ($tipoVista == 'general')
                                <span class="info-box-text">Compromiso:
                                    {{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['nombreRol'] }}</span>
                            @endif
                        </div>
                    </div>
                @endif
            @endfor
        @endfor
    @endif
    @include('livewire.programacion.create')
    @include('livewire.programacion.edit')
    @include('livewire.programacion.ver-recurso')
</div>
