<?php

namespace App\Http\Livewire\Recurso;

use App\Models\Ministerio;
use App\Models\Recurso;
use App\Models\TipoRecurso;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class RecursoIndex extends Component
{

    use WithPagination;
    use WithFileUploads;
    public $columna = "recursos.id", $orden = "asc", $registrosXPagina = 5;
    public $idRecurso;
    public $nombreRecurso;
    public $idTipoRecurso;
    public $idMinisterio;
    public $archivoTemporal;
    public $archivoRecurso;
    public $extension;
    public $mostrarFormEditar = false;
    public $textoBuscar;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        //Obtener listad de recursos
        $recursos = Recurso::join('tipo_recursos', 'tipo_recursos.id', 'tipo_recurso_id')
            ->Orwhere('recursos.nombre', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('tipo_recursos.nombre', 'like', '%' . $this->textoBuscar . '%')
            ->orderBy($this->columna, $this->orden)
            ->paginate($this->registrosXPagina, [
                'recursos.id as idRecurso',
                'recursos.nombre as nombreRecurso',
                'tipo_recursos.nombre as nombreTipoRecurso',
                'url'
            ]);
        //Lista tipos recursos
        $listaTipoRecursos = TipoRecurso::all(['id', 'nombre']);
        //Lista Ministerios
        $listaMinisterios = Ministerio::all(['id', 'nombre']);

        return view('livewire.recurso.recurso-index', compact('recursos', 'listaTipoRecursos', 'listaMinisterios'));
    }
    public function ordenar($columna)
    {
        $this->columna = $columna;
        $this->orden = $this->orden == "asc" ? "desc" : "asc";
    }

    public function create()
    {
        $this->limpiarCampos();
        $this->emit('modal', 'crearRecursoModal', 'show');
    }
    public function store()
    {
        $this->validate([
            'nombreRecurso' => 'required|max:190',
            'idTipoRecurso' => 'required',
            'idMinisterio' => 'required',

        ]);

        try {
            $recurso = Recurso::create();
            $recurso->nombre = $this->nombreRecurso;
            $recurso->tipo_recurso_id = $this->idTipoRecurso;
            $recurso->ministerio_id = $this->idMinisterio;
            $recurso->user_created_id = auth()->id();
            $recurso->save();
            $this->limpiarCampos();
            $this->emit('modal', 'crearRecursoModal', 'hide');
            $this->edit($recurso);
            return session()->flash('success', 'El recurso ha sido creado correctamente');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }

    //Se esta subiendo el archivo desde el controlador de Recurso
    public function subirArchivo()
    {
        //Validar archivo
        $this->validate(['archivoTemporal' => 'image|max:2048']);
        try {
            //Consultar nombre tipo recurso
            $tipoRecurso=TipoRecurso::find($this->idTipoRecurso)->nombre;
            //Almacenar avatar en dropbox
            $dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
            $nombreArchivo=trim($this->nombreRecurso).time().".".$this->archivoTemporal->extension();
            $ruta_enlace = Storage::disk('dropbox')->putFileAs("/recursos/$tipoRecurso", $this->archivoTemporal,$nombreArchivo);
            $response = $dropbox->createSharedLinkWithSettings($ruta_enlace, ["requested_visibility" => "public"]);
            $urlArchivo = str_replace('dl=0', 'raw=1', $response['url']);
            //Almacenar archivo en la carpeta public
            // $path = $this->archivoTemporal->store('public/images/recursos');
            //$path = str_replace('public', 'storage', $path);
            //Guardar en la base de datos
            //Consultar el recurso
            $recurso = Recurso::find($this->idRecurso);
            $recurso->url = $urlArchivo;
            $recurso->extension=$this->archivoTemporal->extension();
            $recurso->user_created_id = auth()->id();
            $recurso->save();
            return session()->flash('success', 'Imagen cargada correctamente.');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error al subir archivo, contacte al administrador del sistema.');
        }
    }

    public function edit(Recurso $recurso)
    {
        $this->reset(['archivoTemporal']);
        $this->idRecurso = $recurso->id;
        $this->nombreRecurso = $recurso->nombre;
        $this->archivoRecurso = $recurso->url;
        $this->extension=$recurso->extension;
        $this->idMinisterio = $recurso->ministerio_id;
        $this->idTipoRecurso = $recurso->tipo_recurso_id;
        $this->emit('modal', 'editarRecursoModal', 'show');
    }
    public function update()
    {
        $this->validate([
            'nombreRecurso' => 'required|max:190',
            'idTipoRecurso' => 'required',
            'idMinisterio' => 'required',

        ]);

        try {
            $recurso = Recurso::find($this->idRecurso);
            $recurso->nombre = $this->nombreRecurso;
            $recurso->tipo_recurso_id = $this->idTipoRecurso;
            $recurso->ministerio_id = $this->idMinisterio;
            $recurso->user_created_id = auth()->id();
            $recurso->save();
            $this->limpiarCampos();
            $this->emit('modal', 'editarRecursoModal', 'hide');
            return session()->flash('success', 'El recurso ha sido actualizado');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }

    public function delete($idRecurso)
    {

        $this->idRecurso = $idRecurso;
        $this->nombre = Recurso::find($idRecurso, ['nombre'])->nombre;
        $this->emit('modal', 'eliminarRecursoModal', 'show');
    }

    public function destroy()
    {
        try {
            Recurso::destroy($this->idRecurso);
            $this->emit('modal', 'eliminarRecursoModal', 'hide');
            $this->limpiarCampos();
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }

    public function limpiarCampos()
    {
        $this->reset(['idRecurso', 'nombreRecurso', 'idTipoRecurso', 'idMinisterio']);
    }
}
