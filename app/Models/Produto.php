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
        'fracionar',
        'data_validade',
        'preco_padrao',
        'status'
    ];

    public function getTipoNomeAttribute(): string
    {
        return match ($this->tipo) {
            'F' => 'Fisico',
            'D' => 'Digital',
            'S' => 'Serviço',
        };
    }

    protected $casts = [
        'status' => ProdutoStatus::class,
    ];


    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categorias_produtos');
    }

    public function tabela_preco_item()
    {
        return $this->hasMany(TabelaPrecoItem::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_produtos');
    }
}
