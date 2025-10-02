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
        Schema::create('pedidos_vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained();
            $table->foreignId('vendedor_id')->constrained('users')->default(1);
            $table->foreignId('vendedor2_id')->nullable()->constrained('users');
            $table->date('data_emissao');
            $table->string('tipo_pessoa');
            $table->string('cpf_cnpj');
            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->string('cep', 9);
            $table->string('endereco', 120);
            $table->string('bairro', 50);
            $table->string('numero', 10);
            $table->string('cidade', 80);
            $table->string('uf', 2);
            $table->foreignId('tabela_preco_id')->constrained('tabelas_precos');
            $table->string('complemento', 120)->nullable();
            $table->decimal('desc1', 10, 2)->default(0.00);
            $table->decimal('desc2', 10, 2)->default(0.00);
            $table->decimal('desc3', 10, 2)->default(0.00);
            $table->decimal('frete', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->char('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos_vendas');
    }
};
