<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Compartilha o total de relatos com todas as views para o footer
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('relatos')) {
                $totalRelatosGlobal = \Illuminate\Support\Facades\Cache::remember('total_relatos_global', 60, function () {
                    return \App\Models\Relato::count();
                });
                view()->share('totalRelatosGlobal', $totalRelatosGlobal);
            }
        } catch (\Exception $e) {
            view()->share('totalRelatosGlobal', 0);
        }
    }
}
