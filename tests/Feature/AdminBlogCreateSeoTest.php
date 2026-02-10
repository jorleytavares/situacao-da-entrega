<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminBlogCreateSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_post_with_seo_data()
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);

        $seoData = [
            'titulo' => 'SEO Post Test',
            'subtitulo' => 'Testing Subtitle',
            'conteudo' => '<p>Content</p>',
            // 'resumo' removed as per requirement
            'sge_summary' => 'Summary for AI LLMs',
            'tags' => 'Logistica, Teste, SEO', // String input from form
            'meta_schema' => '{"@context": "https://schema.org", "@type": "Article"}', // JSON string input
            'autor_nome' => 'Admin Tester',
            'autor_perfil' => 'https://linkedin.com/in/admin',
            'imagem_alt' => 'Alt Text Image',
            'publicado' => 1
        ];

        $response = $this->withSession(['admin_autenticado' => true])
                         ->post(route('admin.blog.store'), $seoData);

        $response->assertRedirect(route('admin.blog.index'));
        $response->assertSessionHas('sucesso');

        $this->assertDatabaseHas('posts', [
            'titulo' => 'SEO Post Test',
            'sge_summary' => 'Summary for AI LLMs',
            'autor_perfil' => 'https://linkedin.com/in/admin',
            'imagem_alt' => 'Alt Text Image',
        ]);

        $post = Post::where('titulo', 'SEO Post Test')->first();
        
        // Verify array casting
        $this->assertIsArray($post->tags);
        $this->assertCount(3, $post->tags);
        $this->assertContains('Logistica', $post->tags);
        
        $this->assertIsArray($post->meta_schema);
        $this->assertEquals('Article', $post->meta_schema['@type']);
    }

    public function test_admin_can_update_post_with_seo_data()
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);

        $post = Post::create([
            'titulo' => 'Original Post',
            'slug' => 'original-post',
            'conteudo' => 'Original Content',
            'autor_nome' => 'Original Author'
        ]);

        $updateData = [
            'titulo' => 'Updated SEO Post',
            'conteudo' => 'Updated Content',
            'tags' => 'New, Tags',
            'meta_schema' => '{"key": "value"}',
            'autor_nome' => 'Original Author'
        ];

        $response = $this->withSession(['admin_autenticado' => true])
                         ->put(route('admin.blog.update', $post), $updateData);

        $response->assertRedirect(route('admin.blog.index'));
        
        $post->refresh();
        $this->assertEquals('Updated SEO Post', $post->titulo);
        $this->assertContains('New', $post->tags);
        $this->assertEquals('value', $post->meta_schema['key']);
    }
}
