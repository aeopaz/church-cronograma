<?php

namespace App\Http\Livewire\Usuario;

use App\Models\Ministerio;
use App\Models\User;
use App\Models\UsuarioMinisterio;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class UsuarioIndex extends Component
{
    use WithPagination;
    public $columna = "id", $orden = "asc", $registrosXPagina = 5;
    protected $paginationTheme = 'bootstrap';
    public $idUsuario;
    public $nombre;
    public $email;
    public $celular;
    public $ministeriosUsuario = [];
    public $textoBuscar;
    public function render()
    {
        //Listar usuarios
        $usuarios = User::where('id', '<>', auth()->id())
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->textoBuscar . '%')
                    ->Orwhere('email', 'like', '%' . $this->textoBuscar . '%')
                    ->Orwhere('celular', 'like', '%' . $this->textoBuscar . '%');
            })->orderBy($this->columna, $this->orden)
            ->paginate($this->registrosXPagina);
        //Lista de ministerios
        $listaMinisterios = Ministerio::all(['id', 'nombre']);
        //Listad de ministerios asociados al usuario
        $ministeriosUsuario = UsuarioMinisterio::join('users', 'users.id', 'id_user')
            ->where('usuario_ministerio.estado', 'A')
            ->where('id_user', $this->idUsuario)
            ->get(['id_user', 'id_ministerio']);
        //Crear array de los ministerios asociados al usuario para mostrar en la vista
        foreach ($ministeriosUsuario as $ministerio) {
            $this->ministeriosUsuario[$ministerio->id_ministerio] = $ministerio->id_ministerio;
        }


        return view('livewire.usuario.usuario-index', compact('usuarios', 'listaMinisterios'));
    }
    public function ordenar($columna)
    {
        $this->columna = $columna;
        $this->orden = $this->orden == "asc" ? "desc" : "asc";
    }
    //Vista actualizar datos usuario
    public function edit(User $usuario)
    {

        $this->idUsuario = $usuario->id;
        $this->nombre = $usuario->name;
        $this->email = $usuario->email;
        $this->celular = $usuario->celular;
        //Limpiar la variable ministeriosUsuario
        $this->reset(['ministeriosUsuario']);

        $this->emit('modal', 'editarUsuarioModal', 'show');
    }
    //Actualizar datos usuario
    public function update($idUsuario)
    {
        $validateData = $this->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'celular' => ['required', 'digits:10'],
        ]);
        try {
            //Validar si el email esta repetido
            $emailRepetido = User::where('email', $this->email)->where('id', '<>', $idUsuario)->first();

            if ($emailRepetido) {
                return session()->flash('fail', 'El email ya se encuentra registrado. Utilice otro');
            }
            $usuario = User::find($idUsuario);
            $usuario->name = $this->nombre;
            $usuario->email = $this->email;
            $usuario->celular = $this->celular;
            $usuario->save();
            $this->emit('modal', 'editarUsuarioModal', 'hide');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
    public function delete(User $usuario)
    {
        $this->idUsuario = $usuario->id;
        $this->nombre = $usuario->name;
        $this->emit('modal', 'eliminarUsuarioModal', 'show');
    }

    public function destroy()
    {
        User::destroy($this->idUsuario);
        $this->emit('modal', 'eliminarUsuarioModal', 'hide');
        // $this->limpiarCampos();

    }
    //Asociar usuario a ministerio
    public function asociarMinisterio($idUsuario, $idMinisterio)
    {

        try {

            //Consultar usuario ministerio
            $usuarioMinisterio = UsuarioMinisterio::where('id_user', $idUsuario)
                ->where('id_ministerio', $idMinisterio)->first();
            //Validar si el usuario tiene asociado el ministerio
            if ($usuarioMinisterio) {
                //Si lo tiene, valida si esta activo
                if ($usuarioMinisterio->estado == 'A') {
                    $usuarioMinisterio->estado = 'I';
                } else {
                    $usuarioMinisterio->estado = 'A';
                }
            } else {
                //Si no lo tiene, lo registra
                $usuarioMinisterio = UsuarioMinisterio::create();
                $usuarioMinisterio->id_user = $idUsuario;
                $usuarioMinisterio->id_ministerio = $idMinisterio;
                $usuarioMinisterio->estado = 'Activo';
            }
            //Almacenar en la base de datos
            $usuarioMinisterio->save();
            return session()->flash('success', 'Ministerios asociados.');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
    public function limpiarCampos()
    {
        $this->reset(['nombre', 'email', 'celular', 'ministerios',]);
    }
}
