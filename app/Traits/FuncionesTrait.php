<?php

namespace App\Traits;

use Carbon\Carbon;

trait FuncionesTrait
{
    public function categorizarXEdad($edad)
    {
        if ($edad >= 0 && $edad < 5) {
            return 'Bebe';
        } elseif ($edad >= 5 && $edad < 12) {
            return 'Niño';
        } elseif ($edad >= 12 && $edad < 18) {
            return 'Adolescente';
        } elseif ($edad >= 18 && $edad < 25) {
            return 'Joven';
        } elseif ($edad >= 25 && $edad < 40) {
            return 'Joven Adulto';
        } elseif ($edad >= 40 && $edad < 55) {
            return 'Adulto';
        } elseif ($edad >= 55 && $edad < 65) {
            return 'Aulto Mayor';
        } elseif ($edad >= 65 && $edad < 75) {
            return 'Anciano';
        } elseif ($edad > 75) {
            return 'Longevo';
        }
    }

    public function nombreCategoriaxEdad()
    {
        return [
            'Bebe' => '0|5',
            'Niño' => '5|12',
            'Adolescente' => '12|18',
            'Joven' => '18|25',
            'Joven Adulto' => '25|40',
            'Adulto' => '40|55',
            'Adulto Mayor' => '55|65',
            'Anciano' => '65|75',
            'Longevo' => '75|200',

        ];
    }

    public function totalizarXCategoriaEdad($datos)
    {
        // $totales=['Bebe','Niño','Adolescente','Joven','JovenAdulto','Adulto','AdultoMayor','Anciano','Longevo'];
        // dd($totales);
        $totales = [];
        $cantBebe = 0;
        $cantNino = 0;
        $cantAdol = 0;
        $cantJove = 0;
        $cantAdulJoven = 0;
        $cantAdulto = 0;
        $cantAdulMayor = 0;
        $cantAnciano = 0;
        $cantLong = 0;
        foreach ($datos as $dato) {
            $edad = Carbon::parse($dato->fecha_nacimiento)->age;
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
        $totales['value'][] = $cantBebe;
        $totales['value'][] = $cantNino;
        $totales['value'][] = $cantAdol;
        $totales['value'][] = $cantJove;
        $totales['value'][] = $cantAdulJoven;
        $totales['value'][] = $cantAdulto;
        $totales['value'][] = $cantAdulMayor;
        $totales['value'][] = $cantAnciano;
        $totales['value'][] = $cantLong;
        return $totales;
    }

    public function mesesMiembroAntiguo()
    {
        return 3;
    }

    public function rutaError()
    {
        return redirect('error\error')->with('fail','Su cuenta esta desactivada, favor contactar a un líder o administrador del sistema para su activación');
    }
}
