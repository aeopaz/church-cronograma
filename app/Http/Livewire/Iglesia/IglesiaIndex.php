<?php

namespace App\Http\Livewire\Iglesia;

use App\Models\Iglesia;
use Livewire\Component;
use Livewire\WithPagination;

class IglesiaIndex extends Component
{
    use WithPagination;
    public $columna="id", $orden="asc",$registrosXPagina=5;
    public $idIglesia;
    public $nombre;
    public $direccion;
    public $telefono;
    public $email;
    protected $paginationTheme = 'bootstrap';


    public function render()
    {
        $iglesias=Iglesia::orderBy($this->columna,$this->orden)
        ->paginate($this->registrosXPagina);
        return view('livewire.iglesia.iglesia-index',compact('iglesias'));
    }

    public function ordenar($columna)
    {
        $this->columna=$columna;
        $this->orden=$this->orden=="asc"?"desc":"asc";
    }

    public function create()
    {
        $this->limpiarCampos();
        $this->emit('modal', 'crearIglesiaModal', 'show');
    }
    public function store()
    {
        $validateData=$this->validate([
            'nombre'=>'required|max:190',
            'direccion'=>'required|max:190',
            'telefono'=>'required|numeric|max:9999999999|min:1111111111',
            'email'=>'required|email|max:190'
        ]);

        Iglesia::create($validateData);
        $this->limpiarCampos();
        $this->emit('modal', 'crearIglesiaModal', 'hide');
    }

    public function edit(Iglesia $iglesia)
    {
        $this->idIglesia=$iglesia->id;
        $this->nombre=$iglesia->nombre;
        $this->direccion=$iglesia->direccion;
        $this->email=$iglesia->email;
        $this->telefono=$iglesia->telefono;
        $this->emit('modal', 'editarIglesiaModal', 'show');
    }
    public function update($id)
    {
        $validateData=$this->validate([
            'nombre'=>'required|max:190',
            'direccion'=>'required|max:190',
            'telefono'=>'required|numeric|max:9999999999|min:1111111111',
            'email'=>'required|email|max:190'
        ]);

        $iglesia=Iglesia::find($id);
        $iglesia->nombre=$this->nombre;
        $iglesia->direccion=$this->direccion;
        $iglesia->email=$this->email;
        $iglesia->telefono=$this->telefono;
        $iglesia->save();
        $this->limpiarCampos();
        $this->emit('modal', 'editarIglesiaModal', 'hide');
    }

    public function delete(Iglesia $iglesia)
    {
        $this->idIglesia=$iglesia->id;
        $this->nombre=$iglesia->nombre;
        $this->emit('modal', 'eliminarIglesiaModal', 'show');
    }

    public function destroy()
    {
        Iglesia::destroy($this->idIglesia);
        $this->emit('modal', 'eliminarIglesiaModal', 'hide');
        $this->limpiarCampos();

    }

    public function limpiarCampos()
    {
        $this->reset(['idIglesia','nombre','direccion','telefono','email']);
    }
}
