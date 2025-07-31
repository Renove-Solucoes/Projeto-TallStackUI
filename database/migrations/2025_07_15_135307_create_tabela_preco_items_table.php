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
        Schema::create('tabela_preco_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tabela_preco_id')->constrained('tabelas_precos');
            $table->foreignId('produto_id')->constrained();
            $table->decimal('preco')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabela_preco_items');
    }
};
