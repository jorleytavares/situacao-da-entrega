<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class AdminBlogDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_post()
    {
        // 1. Setup Admin
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);

        // 2. Create Post
        $post = Post::create([
            'titulo' => 'Post to Delete',
            'slug' => 'post-to-delete',
            'conteudo' => 'Content',
            'publicado' => true
        ]);

        $this->assertDatabaseHas('posts', ['id' => $post->id]);

        // 3. Act: Delete Post
        $response = $this->withSession(['admin_autenticado' => true])
                         ->delete(route('admin.blog.destroy', $post));

        // 4. Assert
        $response->assertRedirect(route('admin.blog.index'));
        $response->assertSessionHas('sucesso', 'Post removido com sucesso!');
        
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
