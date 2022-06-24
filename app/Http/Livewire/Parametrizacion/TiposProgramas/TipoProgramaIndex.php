<?php

namespace App\Http\Livewire\Parametrizacion\TiposProgramas;

use App\Models\TipoProgramacion;
use Livewire\Component;
use Livewire\WithPagination;

class TipoProgramaIndex extends Component
{
    use WithPagination;
    public $columna = "id", $orden = "asc", $registrosXPagina = 5;
    public $idTipoPrograma;
    public $nombre;
    public $textoBuscar;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $tiposPrograma = TipoProgramacion::Orwhere('nombre', 'like', '%' . $this->textoBuscar . '%')
            ->orderBy($this->columna, $this->orden)
            ->paginate($this->registrosXPagina, [
                'id',
                'nombre'
            ]);

            return view('livewire.parametrizacion.tipos-programas.tipo-programa-index', compact('tiposPrograma'));
    }
    public function ordenar($columna)
    {
        $this->columna = $columna;
        $this->orden = $this->orden == "asc" ? "desc" : "asc";
    }

    public function create()
    {
        $this->limpiarCampos();
        $this->emit('modal', 'crearTipoProgramaModal', 'show');
    }
    public function store()
    {
        $validateData = $this->validate([
            'nombre' => 'required|max:190',
        ]);


        TipoProgramacion::create($validateData);
        $this->limpiarCampos();
        $this->emit('modal', 'crearTipoProgramaModal', 'hide');
    }

    public function edit(TipoProgramacion $tipoPrograma)
    {
        $this->idTipoPrograma = $tipoPrograma->id;
        $this->nombre = $tipoPrograma->nombre;
        $this->emit('modal', 'editarTipoProgramaModal', 'show');
    }
    public function update($idTipoPrograma)
    {
        $validateData = $this->validate([
            'nombre' => 'required|max:190',
        ]);

        $tipoPrograma = TipoProgramacion::find($idTipoPrograma);
        $tipoPrograma->nombre = $this->nombre;
        $tipoPrograma->save();
        $this->limpiarCampos();
        $this->emit('modal', 'editarTipoProgramaModal', 'hide');
    }

    public function delete($idTipoPrograma)
    {

        $this->idTipoPrograma = $idTipoPrograma;
        $this->nombre = TipoProgramacion::find($idTipoPrograma, ['nombre'])->nombre;
        $this->emit('modal', 'eliminarTipoProgramaModal', 'show');
    }

    public function destroy()
    {
        TipoProgramacion::destroy($this->idTipoPrograma);
        $this->emit('modal', 'eliminarTipoProgramaModal', 'hide');
        $this->limpiarCampos();
    }

    public function limpiarCampos()
    {
        $this->reset(['idTipoPrograma', 'nombre']);
    }
}
