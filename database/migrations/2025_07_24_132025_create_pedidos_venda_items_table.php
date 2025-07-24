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
        Schema::create('pedidos_venda_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_venda_id')->constrained('pedidos_vendas');
            $table->foreignId('produto_id')->constrained();
            $table->integer('quantidade');
            $table->decimal('preco');
            $table->char('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos_venda_items');
    }
};
