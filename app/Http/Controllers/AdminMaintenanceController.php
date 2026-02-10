<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Relato;
use App\Models\SearchLog;
use App\Models\Post;

class AdminMaintenanceController extends Controller
{
    public function limparCache()
    {
        try {
            Artisan::call('optimize:clear');
            return back()->with('sucesso', 'Cache do sistema limpo com sucesso!');
        } catch (\Exception $e) {
            return back()->with('erro', 'Erro ao limpar cache: ' . $e->getMessage());
        }
    }

    public function limparDados()
    {
        try {
            // Desabilita verificação de chave estrangeira para truncar
            Schema::disableForeignKeyConstraints();
            
            Relato::truncate();
            SearchLog::truncate();
            
            Schema::enableForeignKeyConstraints();

            // Limpa o cache também para refletir a contagem zerada
            Artisan::call('optimize:clear');

            return back()->with('sucesso', 'Todos os relatórios foram removidos com sucesso!');
        } catch (\Exception $e) {
            return back()->with('erro', 'Erro ao limpar dados: ' . $e->getMessage());
        }
    }
}
