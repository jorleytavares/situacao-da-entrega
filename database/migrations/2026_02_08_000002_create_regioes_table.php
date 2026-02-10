<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regioes', function (Blueprint $table) {
            $table->id();
            $table->string('uf', 2);
            $table->string('cidade', 120)->nullable();
            $table->timestamps();

            $table->unique(['uf', 'cidade']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regioes');
    }
};
