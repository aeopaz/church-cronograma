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
    public $color;
    public $colorArray;
    public $textoBuscar;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $this->colorArray = [
            'blue' => 'Azul',
            'fuchsia' => 'Fucsia',
            'red' => 'Rojo',
            'yellow' => 'Amarillo',
            'lime' => 'Verde Limon',
            'aqua' => 'Agua Marina',
            'black' => 'Negro',
            'purple' => 'Púrpura',
            'maroon' => 'Marron',
            'olive' => 'Verde oliva',
            'green' => 'Verde',
            'teal'=>'Verde azulado',
            'gray' => 'Gris',
            'silver' => 'Plateado'
        ];
        $tiposPrograma = TipoProgramacion::Orwhere('nombre', 'like', '%' . $this->textoBuscar . '%')
            ->orderBy($this->columna, $this->orden)
            ->paginate($this->registrosXPagina, [
                'id',
                'nombre',
                'color'

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
            'color' => 'required|in:blue,fuchsia,red,yellow,lime,aqua,black,purple,maroon,olive,green,teal,gray,silver'
        ]);


        TipoProgramacion::create($validateData);
        $this->limpiarCampos();
        $this->emit('modal', 'crearTipoProgramaModal', 'hide');
    }

    public function edit(TipoProgramacion $tipoPrograma)
    {
        $this->idTipoPrograma = $tipoPrograma->id;
        $this->nombre = $tipoPrograma->nombre;
        $this->color = $tipoPrograma->color;
        $this->emit('modal', 'editarTipoProgramaModal', 'show');
    }
    public function update($idTipoPrograma)
    {
        $validateData = $this->validate([
            'nombre' => 'required|max:190',
            'color' => 'required|in:blue,fuchsia,red,yellow,lime,aqua,black,purple,maroon,olive,green,teal,gray,silver'
        ]);

        $tipoPrograma = TipoProgramacion::find($idTipoPrograma);
        $tipoPrograma->nombre = $this->nombre;
        $tipoPrograma->color = $this->color;
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
        $this->reset(['idTipoPrograma', 'nombre', 'color']);
    }
}
