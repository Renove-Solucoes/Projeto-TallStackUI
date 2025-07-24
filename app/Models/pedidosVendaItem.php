<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedidosVendaItem extends Model
{
    protected $fillable = [
        'pedidos_venda_id',
        'produto_id',
        'quantidade',
        'preco',
        'status',
    ];

    public function pedidoVenda()
    {
        return $this->belongsTo(pedidosVenda::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
