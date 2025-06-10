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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            // $table->boolean('principal')->default(false);
            $table->string('descricao', 20);
            $table->string('cep');
            $table->string('endereco', 60);
            $table->string('bairro', 60);
            $table->string('numero', 10);
            $table->string('cidade', 60);
            $table->char('uf', 2);
            $table->string('complemento', 100)->nullable();
            $table->char('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
