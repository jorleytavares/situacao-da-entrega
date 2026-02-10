<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Configuracao;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            try {
                $scriptsHead = Configuracao::scriptsHead();
                $scriptsBody = Configuracao::scriptsBody();

                // GTM body (noscript) vai logo após abrir body
                $scriptsBodyStart = Configuracao::where('ativo', true)
                    ->where('chave', 'google_tag_manager_body')
                    ->pluck('valor')
                    ->filter()
                    ->toArray();
            } catch (\Exception $e) {
                $scriptsHead = [];
                $scriptsBody = [];
                $scriptsBodyStart = [];
            }

            $view->with(compact('scriptsHead', 'scriptsBody', 'scriptsBodyStart'));
        });
    }
}
