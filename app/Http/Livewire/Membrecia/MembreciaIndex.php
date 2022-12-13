<?php

namespace App\Http\Livewire\Membrecia;

use App\Models\Membrecia;
use Livewire\Component;
use Livewire\WithPagination;

class MembreciaIndex extends Component
{
    use WithPagination;
    public $columna = "id", $orden = "asc", $registrosXPagina = 5;
    public $idMiembro;
    public $tipoDocumento;
    public $numeroDocumento=null;
    public $nombre;
    public $apellido;
    public $fechaNacimiento;
    public $fechaConversion;
    public $sexo;
    public $estadoCivil;
    public $celular;
    public $ciudad;
    public $barrio;
    public $direccion;
    public $email;
    public $textoBuscar;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        //Miembros
        $miembros = Membrecia::Orwhere('nombre', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('apellido', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('tipo_documento', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('numero_documento', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('fecha_nacimiento', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('sexo', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('estado_civil', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('celular', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('email', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('ciudad', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('barrio', 'like', '%' . $this->textoBuscar . '%')
            ->Orwhere('direccion', 'like', '%' . $this->textoBuscar . '%')
            ->orderBy($this->columna, $this->orden)
            ->paginate($this->registrosXPagina);
        //Tipos de documento
        $tipoId = [
            'clave' => ['CC', 'CE', 'PS', 'TI'],
            'valor' => ['Ced. Ciudadanía', 'Ced. Extranjería', 'Pasaporte', 'Tarjeta Identidad']
        ];
        //Sexo
        $tipoSexo = [
            'clave' => ['F', 'M'],
            'valor' => ['Femenino', 'Masculino']
        ];
        //Estado Civil
        $tipoEstadoCivil = [
            'clave' => ['S', 'C', 'D', 'U', 'V'],
            'valor' => ['Soltero(a)', 'Casado(a)', 'Divorciado(a)', 'Unión Libre', 'Viudo(a)']
        ];
        //Ciudades
        $nombreCiudad = [
            'clave' => ['Cali', 'Jamundi', 'Palmira', 'Candelaria', 'Bogotá'],
            'valor' => ['Cali', 'Jamundi', 'Palmira', 'Candelaria', 'Bogotá'],

        ];
        //    dd($tipoId['clave'][0]);
        return view('livewire.membrecia.membrecia-index', compact(
            'miembros',
            'tipoId',
            'tipoSexo',
            'tipoEstadoCivil',
            'nombreCiudad'
        ));
    }

    public function ordenar($columna)
    {
        $this->columna = $columna;
        $this->orden = $this->orden == "asc" ? "desc" : "asc";
    }

    public function create()
    {
        $this->limpiarCampos();
        $this->emit('modal', 'crearMiembroModal', 'show');
    }
    public function store()
    {
        $validateData = $this->validate([
            'tipoDocumento' => 'required_with:numeroDocumento',
            //'numeroDocumento' => 'required|digits_between:6,10|unique:membrecias,numero_documento,NULL,id,tipo_documento,' . $this->tipoDocumento,
            'numeroDocumento' => 'required_with:tipoDocumento|nullable|digits_between:6,10',
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:50',
            'fechaNacimiento' => 'required|date',
            'fechaConversion' => 'required|date',
            'sexo' => 'required',
            'estadoCivil' => 'required',
            'celular' => 'required|digits:10',
            'email' => 'required|email',
            'ciudad' => 'required',
            'barrio' => 'required',
            'direccion' => 'required|max:190',
        ]);

        try {
            //Si se ingresa un número de identificación, validar que no exista en la base de datos
            if ($this->numeroDocumento == !null) {
                $miembro = Membrecia::where('tipo_documento', $this->tipoDocumento)->where('numero_documento', $this->numeroDocumento)->get();
                if (count($miembro) > 0) {
                    return session()->flash('fail', 'Ya existe un miembro bajo la misma identificación.');
                }
            }
            $miembro = Membrecia::create();
            $miembro->tipo_documento =$this->tipoDocumento == null ? '' : $this->tipoDocumento;
            $miembro->numero_documento = $this->numeroDocumento == null ? 0 : $this->numeroDocumento;
            $miembro->nombre = $this->nombre;
            $miembro->apellido = $this->apellido;
            $miembro->fecha_nacimiento = $this->fechaNacimiento;
            $miembro->fecha_conversion = $this->fechaConversion;
            $miembro->sexo = $this->sexo;
            $miembro->estado_civil = $this->estadoCivil;
            $miembro->celular = $this->celular;
            $miembro->email = $this->email;
            $miembro->ciudad = $this->ciudad;
            $miembro->barrio = $this->barrio;
            $miembro->direccion = $this->direccion;
            $miembro->id_usuario = auth()->id();
            $miembro->save();
            $this->limpiarCampos();
            $this->emit('modal', 'crearMiembroModal', 'hide');
            $this->edit($miembro);
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }

    public function edit(Membrecia $miembro)
    {
        $this->idMiembro = $miembro->id;
        $this->tipoDocumento = $miembro->tipo_documento;
        $this->numeroDocumento = $miembro->numero_documento;
        $this->nombre = $miembro->nombre;
        $this->apellido = $miembro->apellido;
        $this->fechaNacimiento = $miembro->fecha_nacimiento->toDateString();
        $this->fechaConversion = $miembro->fecha_conversion->toDateString();
        $this->sexo = $miembro->sexo;
        $this->estadoCivil = $miembro->estado_civil;
        $this->celular = $miembro->celular;
        $this->email = $miembro->email;
        $this->ciudad = $miembro->ciudad;
        $this->barrio = $miembro->barrio;
        $this->direccion = $miembro->direccion;
        $this->emit('modal', 'editarMiembroModal', 'show');
    }
    public function update()
    {
        $validateData = $this->validate([
            // 'tipoDocumento' => 'required',
            // 'numeroDocumento' => 'required|digits:10|unique:membrecias,numero_documento,NULL,id,tipo_documento,' . $this->tipoDocumento,
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:50',
            'fechaNacimiento' => 'required|date',
            'fechaConversion' => 'required|date',
            'sexo' => 'required',
            'estadoCivil' => 'required',
            'celular' => 'required|digits:10',
            'email' => 'required|email',
            'ciudad' => 'required',
            'barrio' => 'required',
            'direccion' => 'required|max:190',
        ]);

        try {
            $miembro = Membrecia::find($this->idMiembro);
            // $miembro->tipo_documento = $this->tipoDocumento;
            // $miembro->numero_documento = $this->numeroDocumento;
            $miembro->nombre = $this->nombre;
            $miembro->apellido = $this->apellido;
            $miembro->fecha_nacimiento = $this->fechaNacimiento;
            $miembro->fecha_conversion = $this->fechaConversion;
            $miembro->sexo = $this->sexo;
            $miembro->estado_civil = $this->estadoCivil;
            $miembro->celular = $this->celular;
            $miembro->email = $this->email;
            $miembro->ciudad = $this->ciudad;
            $miembro->barrio = $this->barrio;
            $miembro->direccion = $this->direccion;
            $miembro->id_usuario = auth()->id();
            $miembro->save();
            $this->limpiarCampos();
            $this->emit('modal', 'editarMiembroModal', 'hide');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }

    public function delete(Membrecia $miembro)
    {
        $this->idMiembro = $miembro->id;
        $this->nombre = $miembro->nombre . " " . $miembro->apellido;
        $this->emit('modal', 'eliminarMiembroModal', 'show');
    }

    public function destroy()
    {
        Membrecia::destroy($this->idMiembro);
        $this->emit('modal', 'eliminarMiembroModal', 'hide');
        $this->limpiarCampos();
    }

    public function limpiarCampos()
    {
        $this->reset([
            'tipoDocumento',
            'numeroDocumento',
            'nombre',
            'apellido',
            'fechaNacimiento',
            'fechaConversion',
            'sexo',
            'estadoCivil',
            'celular',
            'email',
            'ciudad',
            'barrio',
            'direccion',
        ]);
    }
}
