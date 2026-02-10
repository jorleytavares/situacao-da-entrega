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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('imagem_title')->nullable()->after('imagem_destaque'); // Nome/Título da imagem
            $table->text('imagem_descricao')->nullable()->after('imagem_alt'); // Descrição longa da imagem
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['imagem_title', 'imagem_descricao']);
        });
    }
};
