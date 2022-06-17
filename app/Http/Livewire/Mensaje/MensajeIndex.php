<?php

namespace App\Http\Livewire\Mensaje;

use App\Models\Mensaje;
use Livewire\Component;

class MensajeIndex extends Component
{
    protected $listeners = ['render' => 'render']; //Oyente del evento

    public $buscar, $columna = 'titulo', $orden = 'desc';
    public $mostrar;
    public function render()
    {
        $mensajes = Mensaje::where('titulo', 'like', '%' . $this->buscar . '%') //Buscar y ordenar
            ->orWhere('cuerpo', 'like', '%' . $this->buscar . '%')
            ->orWhere('cita', 'like', '%' . $this->buscar . '%')
            ->orderBy($this->columna, $this->orden)
            ->get();
        return view('livewire.mensaje.mensaje-index', compact('mensajes'));
    }

    public function ordenar($columna)
    { //Ordenar
        $this->columna = $columna;
        if ($this->orden == 'desc') {
            $this->orden = 'asc';
        } else {
            $this->orden = 'desc';
        }
    }

    public function editar_mensaje(Mensaje $mensaje)
    { //Editar mensaje

        $this->emit('mensaje_edit', $mensaje); //Envía al componente MensajeEdit el mensaje seleccionado para editar
        $this->emit('modal', 'editarMensajeModal', 'show'); //Abre modal editar

    }

    //Marcar mensaje como mostrar
    public function mostrarMensaje($idMensaje)
    {
        try {
            //Consulta si ya hay un mensaje marcado como S
            $mensaje = Mensaje::where('mostrar', 'S')->first();
            //Si lo hay, lo cambia a N
            if ($mensaje->id!=$idMensaje) {
                $mensaje->mostrar = 'N';
                $mensaje->save();
            }
            //Marca como mostrar S al mensaje indicado por el usuario
            $mensaje = Mensaje::find($idMensaje);
            if ($mensaje->mostrar == 'S') {
                $mensaje->mostrar = 'N';
            } else {
                $mensaje->mostrar = 'S';
            }
            $mensaje->save();
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
}
