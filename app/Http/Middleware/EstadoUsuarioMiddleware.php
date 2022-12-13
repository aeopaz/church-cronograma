<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EstadoUsuarioMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->estado=='I')
        {
            return redirect('error\error')->with('fail','La cuenta fue creada, pero se encuentra desactivada, favor contactar a un líder o administrador del sistema para su activación');
        }
        return $next($request);
    }
}
