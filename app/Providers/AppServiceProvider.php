<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Aluno;
use App\Models\AlunoExame;
use App\Models\Recompensa;
use App\Models\Mensalidade;
use App\Models\Aviso;
use App\Models\AvisoView;
use App\Models\ComentarioVideo;
use App\Models\Configuracao;
use App\Models\AvisoGraduacaoMaster;
use App\Models\PedidoItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

    }

}
