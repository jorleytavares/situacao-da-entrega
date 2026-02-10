<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configurar credenciais de teste
        Config::set('app.admin_email', 'admin@test.com');
        Config::set('app.admin_senha', 'password123');
    }

    public function test_admin_redirects_to_login_if_not_authenticated()
    {
        $response = $this->get('/admin/visao-geral');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertViewIs('admin.login');
    }

    public function test_admin_can_login_with_correct_credentials()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'senha' => 'password123',
        ]);

        $response->assertRedirect(route('admin.visao_geral'));
        $response->assertSessionHas('admin_autenticado', true);
        $response->assertSessionHas('admin_email', 'admin@test.com');
    }

    public function test_admin_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'senha' => 'wrongpassword',
        ]);

        $response->assertSessionHas('erro');
        $response->assertSessionMissing('admin_autenticado');
    }

    public function test_admin_can_logout()
    {
        // Simular login
        $this->withSession(['admin_autenticado' => true]);

        $response = $this->post('/admin/logout');

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionMissing('admin_autenticado');
    }

    public function test_rate_limiting_blocks_excessive_login_attempts()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', [
                'email' => 'admin@test.com',
                'senha' => 'wrongpassword',
            ]);
        }

        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'senha' => 'wrongpassword',
        ]);

        $response->assertSessionHas('erro');
        // A mensagem de erro deve conter algo sobre "Muitas tentativas" ou aguardar
        // No controller: "Muitas tentativas. Aguarde {$seconds} segundos."
        $response->assertSessionHas('erro', function ($value) {
            return str_contains($value, 'Muitas tentativas');
        });
    }
}
