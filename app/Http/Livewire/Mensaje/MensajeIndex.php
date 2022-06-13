<?php

namespace App\Http\Livewire\Mensaje;

use App\Models\Mensaje;
use Livewire\Component;

class MensajeIndex extends Component
{
    protected $listeners=['render'=>'render'];//Oyente del evento

    public $buscar, $columna='titulo',$orden='desc';
    public function render()
    {
        $mensajes=Mensaje::where('titulo','like','%'.$this->buscar.'%')//Buscar y ordenar
        ->orWhere('cuerpo','like','%'.$this->buscar.'%')
        ->orWhere('cita','like','%'.$this->buscar.'%')
        ->orderBy($this->columna,$this->orden)
        ->get();
        return view('livewire.mensaje.mensaje-index',compact('mensajes'));
    }

    public function ordenar($columna){//Ordenar
        $this->columna=$columna;
        if($this->orden=='desc'){
            $this->orden='asc';
        }else{
            $this->orden='desc';
        }

    }

    public function editar_mensaje(Mensaje $mensaje){//Editar mensaje

        $this->emit('mensaje_edit',$mensaje);//Envía al componente MensajeEdit el mensaje seleccionado para editar
        $this->emit('modal','editarMensajeModal','show');//Abre modal editar
        
    }


}