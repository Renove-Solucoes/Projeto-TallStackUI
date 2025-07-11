<?php

namespace App\Models;

use App\Enum\ProdutoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory;


    protected $fillable = [
        'sku',
        'nome',
        'tipo',
        'unidade',
        'data_validade',
        'preco_padrao',
        'status'
    ];

    public function getTipoNomeAttribute(): string
    {
        return match ($this->tipo) {
            'F' => 'Fisico',
            'D' => 'Digital',
        };
    }

    protected $casts = [
        'status' => ProdutoStatus::class,
    ];
}
