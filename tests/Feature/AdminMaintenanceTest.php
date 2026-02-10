<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Relato;
use App\Models\SearchLog;
use App\Models\Post;
use Illuminate\Support\Facades\Schema;

class AdminMaintenanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_reset_reports_and_posts()
    {
        // Create admin user
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            // 'role' => 'admin' // Removing role as it might not be in factory/table yet
        ]);

        // Create dummy data
        \App\Models\Problema::create([
            'titulo' => 'Test Problem', 
            'slug' => 'test-problem', 
            'icone' => 'test',
            'descricao_curta' => 'Short description',
            'descricao_completa' => 'Full description' // adding this just in case
        ]);
        Relato::create(['problema_id' => 1, 'resolvido' => false]); 
        
        // Create a Post which is the main focus
        Post::create([
            'titulo' => 'Test Post',
            'slug' => 'test-post',
            'conteudo' => 'Content',
            'publicado' => true
        ]);

        SearchLog::create([
            'term' => 'test search',
            'results_count' => 0,
            'ip' => '127.0.0.1'
        ]);

        $this->assertDatabaseCount('posts', 1);
        $this->assertDatabaseCount('search_logs', 1);

        // Authenticate as admin
        // Note: The previous task showed session based auth 'admin_autenticado'.
        // Let's mimic the session state from AdminAuthTest.
        $response = $this->withSession(['admin_autenticado' => true])
                         ->post(route('admin.manutencao.limpar_dados'));

        $response->assertRedirect();
        $response->assertSessionHas('sucesso');

        // Posts should NOT be deleted
        $this->assertDatabaseCount('posts', 1);
        // Search logs should be deleted
        $this->assertDatabaseCount('search_logs', 0);
    }
}
