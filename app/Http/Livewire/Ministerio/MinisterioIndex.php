<?php

namespace App\Http\Livewire\Ministerio;

use App\Models\Iglesia;
use App\Models\Ministerio;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class MinisterioIndex extends Component
{
    use WithPagination;
    public $columna="ministerios.id", $orden="asc",$registrosXPagina=5;
    public $idMinisterio;
    public $nombre;
    public $id_iglesia;
    public $id_lider;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $ministerios=Ministerio::join('iglesias','iglesias.id','id_iglesia')
        ->join('users','users.id','id_lider')
        ->orderBy($this->columna,$this->orden)
        ->paginate($this->registrosXPagina,[
            'ministerios.nombre as nombreMinisterio',
            'ministerios.id as idMinisterio',
            'iglesias.nombre as nombreIglesia',
            'users.name as nombreLider']);
        $iglesias=Iglesia::all(['id','nombre']);
        $lideres=User::all(['id','name']);
        return view('livewire.ministerio.ministerio-index', compact('ministerios','iglesias','lideres'));
    }
    public function ordenar($columna)
    {
        $this->columna=$columna;
        $this->orden=$this->orden=="asc"?"desc":"asc";
    }

    public function create()
    {
        $this->limpiarCampos();
        $this->emit('modal', 'crearMinisterioModal', 'show');
    }
    public function store()
    {
        $validateData=$this->validate([
            'nombre'=>'required|max:190',
            'id_iglesia'=>'required|numeric',
            'id_lider'=>'required|numeric',
        ]);

        Ministerio::create($validateData);
        $this->limpiarCampos();
        $this->emit('modal', 'crearMinisterioModal', 'hide');
    }

    public function edit(Ministerio $ministerio)
    {
        $this->idMinisterio=$ministerio->id;
        $this->nombre=$ministerio->nombre;
        $this->id_iglesia=$ministerio->id_iglesia;
        $this->id_lider=$ministerio->id_lider;
        $this->emit('modal', 'editarMinisterioModal', 'show');
    }
    public function update($id)
    {
        $validateData=$this->validate([
            'nombre'=>'required|max:190',
            'id_iglesia'=>'required|numeric',
            'id_lider'=>'required|numeric',
        ]);

        $ministerio=Ministerio::find($id);
        $ministerio->nombre=$this->nombre;
        $ministerio->id_iglesia=$this->id_iglesia;
        $ministerio->id_lider=$this->id_lider;
        $ministerio->save();
        $this->limpiarCampos();
        $this->emit('modal', 'editarMinisterioModal', 'hide');
    }

    public function delete($idMinisterio)
    {

        $this->idMinisterio=$idMinisterio;
        $this->nombre=Ministerio::find($idMinisterio,['nombre'])->nombre;
        $this->emit('modal', 'eliminarMinisterioModal', 'show');
    }

    public function destroy()
    {
        Ministerio::destroy($this->idMinisterio);
        $this->emit('modal', 'eliminarMinisterioModal', 'hide');
        $this->limpiarCampos();

    }

    public function limpiarCampos()
    {
        $this->reset(['idMinisterio','nombre','id_iglesia','id_lider']);
    }
}
