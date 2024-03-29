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
        Schema::create('administradora_investimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('administradora_id')->references('id')->on('administradoras');
            $table->foreignId('investimento_id')->references('id')->on('investimentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administradora_investimentos');
    }
};
