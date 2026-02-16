<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProblemaController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\TendenciaController;
use App\Http\Controllers\RelatoController;
use App\Http\Controllers\InstitucionalController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\TransportadoraController; // Importante

/*
|--------------------------------------------------------------------------
| SEO - Sitemap
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', [SitemapController::class, 'index'])
    ->name('sitemap');

// ROTA DE EMERGÊNCIA - REMOVER APÓS USO
Route::get('/fix-server', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        return "CACHE LIMPO COM SUCESSO! Tente acessar a home.";
    } catch (\Exception $e) {
        return "Erro: " . $e->getMessage();
    }
});

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/buscar', [\App\Http\Controllers\SearchController::class, 'index'])
    ->name('busca');

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/encomenda-parada', [ProblemaController::class, 'mostrar'])
    ->defaults('slug', 'encomenda-parada')
    ->name('problema.encomenda_parada');

Route::get('/entrega-atrasada', [ProblemaController::class, 'mostrar'])
    ->defaults('slug', 'entrega-atrasada')
    ->name('problema.entrega_atrasada');

Route::get('/objeto-nao-localizado', [ProblemaController::class, 'mostrar'])
    ->defaults('slug', 'objeto-nao-localizado')
    ->name('problema.objeto_nao_localizado');

Route::get('/fiscalizacao', [ProblemaController::class, 'mostrar'])
    ->defaults('slug', 'fiscalizacao')
    ->name('problema.fiscalizacao');

Route::get('/nao-saiu-para-entrega', [ProblemaController::class, 'mostrar'])
    ->defaults('slug', 'nao-saiu-para-entrega')
    ->name('problema.nao_saiu');

Route::get('/tendencias', [TendenciaController::class, 'index'])
    ->name('tendencias');

Route::get('/calculadora-taxas', [\App\Http\Controllers\CalculadoraTaxaController::class, 'index'])
    ->name('calculadora.taxas');

/*
|--------------------------------------------------------------------------
| SEO Programático - Páginas Dinâmicas
|--------------------------------------------------------------------------
*/

Route::get('/problema/{slug}', [ProblemaController::class, 'mostrar'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('problema.mostrar');

/*
|--------------------------------------------------------------------------
| Rotas por Estado (SEO Local)
|--------------------------------------------------------------------------
*/

Route::get('/estado/{uf}', [EstadoController::class, 'mostrar'])
    ->where('uf', '[A-Za-z]{2}')
    ->name('estado.mostrar');

Route::get('/transportadoras', [TransportadoraController::class, 'index'])
    ->name('transportadora.index');

Route::get('/transportadora/{slug}', [TransportadoraController::class, 'mostrar'])
    ->name('transportadora.mostrar');

// Blog (SEO / Conteúdo)
Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

/*
|--------------------------------------------------------------------------
| Relatos Anônimos
|--------------------------------------------------------------------------
*/

Route::get('/relatar', [RelatoController::class, 'formulario'])
    ->name('relato.formulario');

Route::post('/relatar', [RelatoController::class, 'salvar'])
    ->name('relato.salvar');

/*
|--------------------------------------------------------------------------
| Páginas Institucionais
|--------------------------------------------------------------------------
*/

Route::get('/como-funciona', [InstitucionalController::class, 'comoFunciona'])
    ->name('como.funciona');

Route::get('/sobre', [InstitucionalController::class, 'sobre'])
    ->name('sobre');

Route::get('/aviso-legal', [InstitucionalController::class, 'avisoLegal'])
    ->name('aviso_legal');

Route::get('/privacidade', [InstitucionalController::class, 'privacidade'])
    ->name('politica_privacidade');

Route::get('/contato', [InstitucionalController::class, 'contato'])
    ->name('contato');

Route::get('/metodologia-dos-dados', [InstitucionalController::class, 'metodologia'])
    ->name('metodologia');

/*
|--------------------------------------------------------------------------
| Ferramentas Úteis
|--------------------------------------------------------------------------
*/

Route::get('/ferramentas/declaracao-conteudo', [\App\Http\Controllers\FerramentasController::class, 'declaracaoConteudo'])
    ->name('ferramentas.declaracao');

/*
|--------------------------------------------------------------------------
| Admin - Autenticação
|--------------------------------------------------------------------------
*/

Route::get('/admin/dash-hostamazonas', [AdminAuthController::class, 'loginForm'])
    ->name('admin.login');

Route::post('/admin/dash-hostamazonas', [AdminAuthController::class, 'login'])
    ->name('admin.login.post');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin - Rotas Protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('admin.auth')->prefix('admin')->group(function () {

    Route::redirect('/', '/admin/visao-geral');

    Route::get('/visao-geral', [AdminDashboardController::class, 'index'])
        ->name('admin.visao_geral');

    Route::get('/exportar-csv', [AdminDashboardController::class, 'exportarCsv'])
        ->name('admin.exportar_csv');

    Route::get('/codigos', [ConfiguracaoController::class, 'codigos'])
        ->name('admin.codigos');

    Route::post('/codigos', [ConfiguracaoController::class, 'salvarCodigos'])
        ->name('admin.codigos.salvar');

    // Admin Blog
    Route::resource('blog', \App\Http\Controllers\AdminBlogController::class)
        ->names('admin.blog')
        ->except(['show']);

    // Admin Media
    Route::post('media/sync', [\App\Http\Controllers\AdminMediaController::class, 'sync'])
        ->name('admin.media.sync');

    Route::resource('media', \App\Http\Controllers\AdminMediaController::class)
        ->names('admin.media')
        ->only(['index', 'store', 'destroy', 'update']);

    // Admin Comentários
    Route::resource('comentarios', \App\Http\Controllers\AdminComentarioController::class)
        ->names('admin.comentarios')
        ->only(['index', 'update', 'destroy']);

    // Admin Manutenção
    Route::post('/manutencao/limpar-cache', [\App\Http\Controllers\AdminMaintenanceController::class, 'limparCache'])
        ->name('admin.manutencao.limpar_cache');

    Route::post('/manutencao/limpar-dados', [\App\Http\Controllers\AdminMaintenanceController::class, 'limparDados'])
        ->name('admin.manutencao.limpar_dados');
});

// Comentários (Frontend)
Route::post('/blog/{slug}/comentar', [\App\Http\Controllers\ComentarioController::class, 'store'])
    ->name('comentarios.store');
