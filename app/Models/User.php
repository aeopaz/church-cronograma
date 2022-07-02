<?php

namespace App\Models;

use Faker\Factory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function programacion()
    {
        return $this->hasMany('App\Models\ParticipantesProgramacionMinisterio');
    }
    public function programacionPropia()
    {
        return $this->hasMany('App\Models\Programacion');
    }

    public function adminlte_image()
    {
        $faker = Factory::create('es_VE');
        if (auth()->user()->avatar == '') {
            return $faker->imageUrl(100, 100, null, false, auth()->user()->iniciales_nombre);
        } else {
            return auth()->user()->avatar;
        }
    }

    public function adminlte_desc()
    {

        return TipoUsuario::where('id', auth()->user()->tipo_usuario_id)->first(['nombre'])->nombre;
    }
    public function adminlte_profile_url()
    {
        return '/usuario/perfil';
    }

    public function getInicialesNombreAttribute()
    {
        $explode = explode(' ', $this->name);
        $iniciales = '';
        foreach ($explode as $x) {
            $iniciales .= $x[0];
        }

        return $iniciales;
    }

    public function getUrlAvatar()
    {
        $faker = Factory::create('es_VE');
        return $faker->imageUrl(100, 100, null, false, $this->name);
    }
}
