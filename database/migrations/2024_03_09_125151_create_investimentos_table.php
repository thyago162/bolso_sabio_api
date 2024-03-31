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
            $table->string('descricao');
            $table->string('taxa_negociada')->nullable();
            $table->integer('quantidade')->default(0);
            $table->double('valor_aplicado', 10, 2)->nullable();
            $table->double('valor_bruto', 10, 2);
            $table->double('valor_liquido', 10, 2)->nullable();
            $table->double('valor_unitario', 10, 2)->default(0);
            $table->date('vencimento')->nullable();
            $table->foreignId('tipo_investimento_id')->references('id')->on('tipo_investimentos');
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');

            $table->softDeletes();
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
