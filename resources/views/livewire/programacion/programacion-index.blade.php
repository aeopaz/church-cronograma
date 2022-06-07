<div>
    @if ($tipoVista=='propia')
    <x-adminlte-button label="Nueva Programación" theme="primary" wire:click='create' /> <br>
    @endif
    
    {{--Primer for que recorre los años de los programas ---}}
    @for ($i = 0; $i < count($anosPrograma); $i++)
        <h1>{{ $anosPrograma[$i] }}</h1><br>
         {{--Segundo for que recorre los programas agrupados por años ---}}
        @for ($j = 0; $j < count($grupoxAnoxMes); $j++)
         {{--Validar si el índice se encuentra definido en la variable ---}}
            @if (isset($grupoxAnoxMes[$j][$anosPrograma[$i]]))
                <div class="info-box @if($j%2==0) bg-success @else bg-primary  @endif" wire:click='edit({{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['idPrograma'] }})'>                     
                    <span class="info-box-icon bg-light" style="width: 150px">{{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['diaPrograma'] }}</span>
                    <div class="info-box-content">
                        <span class="info-box-number">{{$grupoxAnoxMes[$j][$anosPrograma[$i]][0]['nombrePrograma']  }}</span>
                        <span class="info-box-text">Hora: {{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['horaPrograma'] }}</span>
                        <span class="info-box-text">Organizador: {{ $grupoxAnoxMes[$j][$anosPrograma[$i]][0]['nombreUsuarioCreador'] }}</span>
                    </div>
                </div>
            @endif
        @endfor
    @endfor
    @include('livewire.programacion.create')
    @include('livewire.programacion.edit')
</div>
