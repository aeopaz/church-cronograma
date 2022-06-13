<?php

namespace App\Http\Livewire\Mensaje;

use Livewire\Component;
use App\Models\Mensaje;

class MensajeEdit extends Component
{
    public $mensaje;

    protected $listeners=['mensaje_edit'];//Escucha el evento con la variable enviada desde el index

    protected  $rules=[//Validación de campos
        'mensaje.titulo' => 'required|max:45',
        'mensaje.cuerpo' => 'required|max:200',
        'mensaje.cita'   => 'required|max:45',
    ];

    public function render()
    {
        return view('livewire.mensaje.mensaje-edit');
    }

    public function mensaje_edit(Mensaje $mensaje){//Asigna a la variable mensaje el valor recibido del componente MensaIndex
       // dd($mensaje);
        $this->mensaje=$mensaje;
    }

    public function update_mensaje(){
        $this->validate();//Valida campos y actualiza
        $mensaje=Mensaje::find($this->mensaje->id);
        $mensaje->titulo=$this->mensaje->titulo;
        $mensaje->cuerpo=$this->mensaje->cuerpo;
        $mensaje->cita=$this->mensaje->cita;
        $mensaje->save();

        $this->emit('modal','editarMensajeModal','hide');//Cierra Modal
        $this->emit('render');//Envía evento al componenente MensajeIndex para que renderise

    }

}