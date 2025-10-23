<?php

namespace App\Models;

use App\Enum\FormasPagamentosStatus;
use App\Enum\FormasPagamentosTipos;
use App\Enum\FormasPagamentosAplicavel;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormasPagamentos extends Model
{
    /** @use HasFactory<\Database\Factories\FormasPagamentosFactory> */
    use HasFactory;

    protected $fillable = [
        'descricao',
        'tipo_pagamento',
        'condicao_pagamento',
        'aplicavel_em',
        'juros',
        'multa',
        'lancar_dia_util',
        'status'
    ];

    protected $casts = [

        'aplicavel_em' => FormasPagamentosAplicavel::class,
        'status' => FormasPagamentosStatus::class,
        'tipo_pagamento' => FormasPagamentosTipos::class,
        'lancar_dia_util' => 'boolean',

    ];
}
