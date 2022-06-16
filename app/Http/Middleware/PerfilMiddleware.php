<?php

namespace App\Http\Middleware;

use App\Models\TipoUsuario;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $perfil)
    {
        //Consultar perfil del usuario
        $perfilUsuario = TipoUsuario::find(Auth::user()->tipo_usuario_id);
        //Recibo una cadena, la convierto en array y valido si el perfil del usuario autenticado se encuentra en el array
        if (!in_array($perfilUsuario->nombre,explode('|',$perfil))) {
            //Si el perfil que tiene el usuario no coincide con el que requiere la ruta o método, no puede continuar
            abort(403);
        }
        return $next($request);
    }
}
