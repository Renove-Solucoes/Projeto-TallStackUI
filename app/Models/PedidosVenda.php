<?php

namespace App\Models;

use App\Enum\pedidosVendaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosVenda extends Model
{
    /** @use HasFactory<\Database\Factories\PedidosVendaFactory> */
    use HasFactory;

    protected $attributes = [
        'vendedor_id' => 1,
    ];

    protected $fillable = [
        'cliente_id',
        'vendedor_id',
        'vendedor2_id',
        'data_emissao',
        'tipo_pessoa',
        'cpf_cnpj',
        'nome',
        'email',
        'telefone',
        'cep',
        'endereco',
        'bairro',
        'numero',
        'cidade',
        'uf',
        'complemento',
        'tabela_preco_id',
        'desc1',
        'desc2',
        'desc3',
        'frete',
        'total',
        'status',
    ];

    public function getVendedoresNomesAttribute(): string
    {
        $nomes = [];


        if ($this->vendedor?->name) {
            $nomes[] = $this->vendedor->name;
        }

        if ($this->vendedor2?->name) {
            $nomes[] = $this->vendedor2->name;
        }



        return implode(' / ', $nomes);
    }


    protected $casts = [
        'status' => pedidosVendaStatus::class
    ];

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id')->where('vendedor', 1);
    }

    public function vendedor2()
    {
        return $this->belongsTo(User::class, 'vendedor2_id')->where('vendedor', 1);
    }


    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tabelaPreco()
    {
        return $this->belongsTo(TabelaPreco::class);
    }

    public function itens()
    {
        return $this->hasMany(PedidosVendaItem::class);
    }
}
