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
        Schema::create('formas_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->string('tipo_pagamento');
            $table->string('condicao_pagamento');
            $table->char('aplicavel_em');
            $table->decimal('juros', 10, 2)->default(0.00);
            $table->decimal('multa', 10, 2)->default(0.00);
            $table->boolean('lancar_dia_util')->default(false);
            $table->char('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formas_pagamentos');
    }
};
