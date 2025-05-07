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
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->text('descricao');
            $table->date('data');
            $table->enum('tipo', ['entrada', 'saida']);
            $table->enum('natureza', ['produto', 'serviço']);
            $table->foreignId('conta_id')->nullable()->constrained('contas');
            $table->foreignId('cartao_id')->nullable()->constrained('cartoes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacaos');
    }
};
