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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_pessoa');
            $table->string('cpf_cnpj');
            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->date('nascimento');
            $table->decimal('credito', 10, 2);
            $table->boolean('credito_ativo')->default(true);
            $table->string('foto')->nullable();
            $table->char('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
