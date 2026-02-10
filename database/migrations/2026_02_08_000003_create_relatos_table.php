<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('relatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('problema_id')->constrained('problemas')->onDelete('cascade');
            $table->foreignId('regiao_id')->nullable()->constrained('regioes')->onDelete('set null');
            $table->date('data_ocorrencia')->nullable();
            $table->boolean('resolvido')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relatos');
    }
};
