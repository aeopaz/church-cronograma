<?php

namespace App\Http\Livewire\Parametrizacion\Roles;

use App\Models\Rol;
use Livewire\Component;
use Livewire\WithPagination;

class RolesIndex extends Component
{
    use WithPagination;
    public $columna = "id", $orden = "asc", $registrosXPagina = 5;
    public $idRol;
    public $nombre;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $roles = Rol::orderBy($this->columna, $this->orden)
            ->paginate($this->registrosXPagina, [
                'id',
                'nombre'
            ]);

        return view('livewire.parametrizacion.roles.roles-index', compact('roles'));
    }
    public function ordenar($columna)
    {
        $this->columna = $columna;
        $this->orden = $this->orden == "asc" ? "desc" : "asc";
    }

    public function create()
    {
        $this->limpiarCampos();
        $this->emit('modal', 'crearRolModal', 'show');
    }
    public function store()
    {
        $validateData = $this->validate([
            'nombre' => 'required|max:190',
        ]);


        Rol::create($validateData);
        $this->limpiarCampos();
        $this->emit('modal', 'crearRolModal', 'hide');
    }

    public function edit(Rol $rol)
    {
        $this->idRol = $rol->id;
        $this->nombre = $rol->nombre;
        $this->emit('modal', 'editarRolModal', 'show');
    }
    public function update($id)
    {
        $validateData = $this->validate([
            'nombre' => 'required|max:190',
        ]);

        $rol = Rol::find($id);
        $rol->nombre = $this->nombre;
        $rol->save();
        $this->limpiarCampos();
        $this->emit('modal', 'editarRolModal', 'hide');
    }

    public function delete($idRol)
    {

        $this->idRol = $idRol;
        $this->nombre = Rol::find($idRol, ['nombre'])->nombre;
        $this->emit('modal', 'eliminarRolModal', 'show');
    }

    public function destroy()
    {
        Rol::destroy($this->idRol);
        $this->emit('modal', 'eliminarRolModal', 'hide');
        $this->limpiarCampos();
    }

    public function limpiarCampos()
    {
        $this->reset(['idRol', 'nombre']);
    }
}
