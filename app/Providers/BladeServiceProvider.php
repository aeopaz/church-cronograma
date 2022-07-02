<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('fechaMesDia', function ($fecha) {
 
            dd($fecha);
            dd(Carbon::parse($fecha)->format('F j'));
           /* // $numeroMes=substr($fecha,5,2)*1-1;
            // $nombreMes=['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
            // dd($mes);
            
             return "<?php echo  '$nombreMes[$numeroMes]';?>";*/
        });
        Blade::directive('iniciales', function ($nombre) {

            $explode=explode(' ',$nombre);
            $iniciales='';
            foreach ($explode as $x) {
                $iniciales.=$x[0];
            }
    
             return "<?php echo  '$iniciales';?>";
        });
    }
}
