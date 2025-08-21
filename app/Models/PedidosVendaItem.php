<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidosVendaItem extends Model
{
    protected $fillable = [
        'pedidos_venda_id',
        'produto_id',
        'quantidade',
        'preco',
        'desconto',
        'status',
    ];

    public function pedidosVenda()
    {
        return $this->belongsTo(PedidosVenda::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
