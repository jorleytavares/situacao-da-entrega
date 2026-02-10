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
        Schema::create('transportadoras', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->string('descricao')->nullable();
            $table->string('url_site')->nullable();
            $table->string('cor')->nullable(); // Para UI
            $table->timestamps();
        });

        // Adicionar FK na tabela relatos
        Schema::table('relatos', function (Blueprint $table) {
            $table->foreignId('transportadora_id')->nullable()->after('id')->constrained('transportadoras')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relatos', function (Blueprint $table) {
            $table->dropForeign(['transportadora_id']);
            $table->dropColumn('transportadora_id');
        });
        Schema::dropIfExists('transportadoras');
    }
};
