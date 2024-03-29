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
        Schema::create('resumo_negociacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investimento_id')->references('id')->on('investimentos');
            $table->float('total_compras', 10);
            $table->float('total_vendas', 10);
            $table->integer('qnt_compras');
            $table->integer('qnt_vendas');
            $table->float('valor_ativo', 10);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->date('dt_negociacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aportes');
    }
};
