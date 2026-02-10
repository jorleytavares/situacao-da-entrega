<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();

            // Conteúdo principal (HTML rico para semântica)
            $table->longText('conteudo');

            // Resumo para Meta Description e OG:Description
            $table->text('resumo')->nullable();

            // Resumo otimizado para IAs (SGE - Search Generative Experience)
            // Um texto direto e explicativo, ideal para featured snippets
            $table->text('sge_summary')->nullable();

            // Imagem de destaque (OG:Image)
            $table->string('imagem_destaque')->nullable();
            $table->string('imagem_alt')->nullable(); // Alt text para SEO acessibilidade

            // Dados Estruturados (JSON-LD) customizáveis
            // Permite injetar schemas específicos por post (FAQ, HowTo, Article)
            $table->json('meta_schema')->nullable();

            // Taxonomia (Tags/Categorias)
            $table->json('tags')->nullable();

            // Autor (Google E-E-A-T)
            $table->string('autor_nome')->default('Equipe Situação da Entrega');
            $table->string('autor_perfil')->nullable(); // Link para perfil social/bio

            // Controle de publicação
            $table->boolean('publicado')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
