<?php

namespace App\Http\Livewire\Usuario;

use App\Models\Ministerio;
use App\Models\User;
use App\Models\UsuarioMinisterio;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Spatie\Dropbox\Client;
use App\File;

class UsuarioPerfil extends Component
{
    use WithFileUploads;
    public $idUsuario;
    public $nombre;
    public $email;
    public $celular;
    public $foto;
    public $oldPassword;
    public $newPassword;
    public $newPassword_confirmation;
    public $ministeriosUsuario = [];
    public $tipoVista;
  


 
    public function mount($tipoVista)
    {
        $this->tipoVista = $tipoVista;
    }
    public function render()
    {
        //Consultar usuario
        $usuario = User::find(auth()->id(), ['id', 'name', 'email', 'celular', 'avatar']);
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
        return view('livewire.usuario.usuario-perfil', compact('usuario', 'listaMinisterios'));
    }

    //Vista actualizar datos usuario
    public function edit()
    {
        $usuario = User::find(auth()->id());
        $this->idUsuario = $usuario->id;
        $this->nombre = $usuario->name;
        $this->email = $usuario->email;
        $this->celular = $usuario->celular;
        $this->emit('modal', 'editarUsuarioModal', 'show');
    }
    //Actualizar datos usuario
    public function update()
    {
        $validateData = $this->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'celular' => ['required', 'digits:10'],
        ]);
        try {
            //Validar si el email esta repetido
            $emailRepetido = User::where('email', $this->email)->where('id', '<>', auth()->id())->first();

            if ($emailRepetido) {
                return session()->flash('fail', 'El email ya se encuentra registrado. Utilice otro');
            }
            $usuario = User::find(auth()->id());
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

    
    public function subir()
    {

        
    }

    //Subir avatar del usuario
    public function subirFoto()
    {
        //Validar avatar
        $this->validate([
            'foto' => 'image|max:2048', // 2MB Max
        ]);

        try {
            //Almacenar avatar en dropbox
            $dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient(); 
            $nombreArchivo=auth()->user()->email.time().".".$this->foto->extension();
            $ruta_enlace=Storage::disk('dropbox')->putFileAs('/avatar',$this->foto,$nombreArchivo);  
            $response = $dropbox->createSharedLinkWithSettings($ruta_enlace, ["requested_visibility" => "public"]);
            $urlArchivo=str_replace('dl=0','raw=1',$response['url']);
            //Almacenar avatar de forma local en la carpeta pública
            //$path = $this->foto->store('public/images/profile');
            //$path = str_replace('public', 'storage', $path);
            //Guardar en la base de datos
            $usuario = User::find(auth()->id());
            $usuario->avatar = $urlArchivo;
            $usuario->save();
            return session()->flash('success', 'Imagen cargada correctamente.');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error al subir archivo, contacte al administrador del sistema.');
        }
    }

    //Vista actualizar contraseña
    public function editPassword()
    {
        $this->emit('modal', 'editarContrasenaModal', 'show');
    }

    //Cambiar contraseña
    public function updatePassword()
    {
        $validateData = $this->validate([
            'oldPassword' => ['required'],
            'newPassword' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $usuario = User::find(auth()->id());
            if (Hash::check($this->oldPassword, $usuario->password)) {
                $usuario->password = Hash::make($this->newPassword);
                $usuario->save();
                $this->emit('modal', 'editarContrasenaModal', 'hide');
            } else {
                return session()->flash('fail', 'La contaseña anterior es incorrecta.');
            }
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
}
