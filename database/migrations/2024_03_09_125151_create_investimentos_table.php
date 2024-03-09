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
        Schema::create('investimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_ativo');
            $table->double('valor_unitario', 10, 2);
            $table->integer('quantidade')->default(0);
            $table->foreignId('tipo_investimento_id')->references('id')->on('tipo_investimentos');
            $table->foreignId('categoria_id')->references('id')->on('categorias');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investimentos');
    }
};
