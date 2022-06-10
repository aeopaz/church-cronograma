<?php

namespace App\Providers;

use App\Models\Programacion;
use App\Models\TipoUsuario;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function (User $user) {
            $perfilUsuario = TipoUsuario::find($user->tipo_usuario_id);
            return 'admin' == $perfilUsuario->nombre;
        });
        Gate::define('lider', function (User $user) {
            $perfilUsuario = TipoUsuario::find($user->tipo_usuario_id);
            return 'lider' == $perfilUsuario->nombre;
        });
        Gate::define('usuario', function (User $user) {
            $perfilUsuario = TipoUsuario::find($user->tipo_usuario_id);
            return 'usuario' == $perfilUsuario->nombre;
        });
    }
}
