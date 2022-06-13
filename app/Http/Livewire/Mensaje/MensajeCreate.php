<?php

namespace App\Http\Livewire\Mensaje;

use Livewire\Component;
use App\Models\Mensaje;

class MensajeCreate extends Component
{
    public $titulo, $cuerpo, $cita;

    protected  $rules=[
        'titulo' => 'required|max:45',
        'cuerpo' => 'required|max:200',
        'cita'   => 'required|max:45',
    ];

    public function create_mensaje(){

        $this->emit('modal','crearMensajeModal','show');
    }
    public function store_mensaje(){

        $this->validate();
        $mensaje= new Mensaje();
        $mensaje->titulo=$this->titulo;
        $mensaje->cuerpo=$this->cuerpo;
        $mensaje->cita=$this->cita;
        $mensaje->save();
        $this->reset(['titulo','cuerpo','cita']);
        $this->emit('modal','crearMensajeModal','hide');
        $this->emit('render');

    }

    public function render()
    {
        return view('livewire.mensaje.mensaje-create');
    }
}