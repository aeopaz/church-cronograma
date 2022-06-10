<?php

namespace App\Http\Livewire\Panel;

use App\Models\Membrecia;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PanelIndex extends Component
{
    public $sexo;
    public function render()
    {
        $miembros = Membrecia::where('sexo','like','%'.$this->sexo.'%')->get();
        //Categorizar por edad
        $dataPerfilEdad = [];
        $cantBebe = 0;
        $cantNino = 0;
        $cantAdol = 0;
        $cantJove = 0;
        $cantAdulJoven = 0;
        $cantAdulto = 0;
        $cantAdulMayor = 0;
        $cantAnciano = 0;
        $cantLong = 0;
        foreach ($miembros as $miembro) {
            $edad = $miembro->fecha_nacimiento->age;
            if ($edad >= 0 && $edad < 5) {
                $cantBebe = $cantBebe + 1;
            } elseif ($edad >= 5 && $edad < 12) {
                $cantNino = $cantNino + 1;
            } elseif ($edad >= 12 && $edad < 18) {
                $cantAdol = $cantAdol + 1;
            } elseif ($edad >= 18 && $edad < 25) {
                $cantJove = $cantJove + 1;
            } elseif ($edad >= 25 && $edad < 40) {
                $cantAdulJoven = $cantAdulJoven + 1;
            } elseif ($edad >= 40 && $edad < 55) {
                $cantAdulto = $cantAdulto + 1;
            } elseif ($edad >= 55 && $edad < 65) {
                $cantAdulMayor = $cantAdulMayor + 1;
            } elseif ($edad >= 65 && $edad < 75) {
                $cantAnciano = $cantAnciano + 1;
            } elseif ($edad > 75) {
                $cantLong = $cantLong + 1;
            }
        }
        $dataPerfilEdad['label'][] = 'Bebe';
        $dataPerfilEdad['label'][] = 'Nino';
        $dataPerfilEdad['label'][] ='Adolescente';
        $dataPerfilEdad['label'][] = 'Joven';
        $dataPerfilEdad['label'][] = 'AdultoJoven';
        $dataPerfilEdad['label'][] = 'Adulto';
        $dataPerfilEdad['label'][] = 'AdultoMayor';
        $dataPerfilEdad['label'][] = 'Anciano';
        $dataPerfilEdad['label'][] = 'Longevo';

        $dataPerfilEdad['value'][] = $cantBebe;
        $dataPerfilEdad['value'][] = $cantNino;
        $dataPerfilEdad['value'][] = $cantAdol;
        $dataPerfilEdad['value'][] = $cantJove;
        $dataPerfilEdad['value'][] = $cantAdulJoven;
        $dataPerfilEdad['value'][] = $cantAdulto;
        $dataPerfilEdad['value'][] = $cantAdulMayor;
        $dataPerfilEdad['value'][] = $cantAnciano;
        $dataPerfilEdad['value'][] = $cantLong;
        $dataPerfilEdad['data'] = json_encode($dataPerfilEdad);
        //Categorizar por sexo
        $miembrosxSexo = Membrecia::select('sexo', DB::raw('COUNT(sexo) AS cantidad'))
            ->groupBy('sexo')
            ->get();
        $dataSexo = [];
        foreach ($miembrosxSexo as $miembro) {
            $dataSexo['label'][] = $miembro->sexo;
            $dataSexo['value'][] = (int) $miembro->cantidad;
        }
      
        $dataSexo['data'] = json_encode($dataSexo);
        $this->dispatchBrowserEvent('actualizar', [
            'data1' => $dataSexo,
            'data2' => $dataPerfilEdad,
        ]);

        return view('livewire.panel.panel-index', compact('dataSexo','dataPerfilEdad'));
    }
}
