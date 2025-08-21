<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaPrecoItem extends Model
{
    /** @use HasFactory<\Database\Factories\TabelaPrecoItemFactory> */
    use HasFactory;

    protected $fillable = [
        'tabela_preco_id',
        'produto_id',
        'preco',
        'status',
    ];

    public function tabelaPreco()
    {
        return $this->belongsTo(tabelaPreco::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
