<?php

namespace App\Models;

use App\Enum\pedidosVendaStatus;
use Illuminate\Database\Eloquent\Model;

class PedidosVenda extends Model
{



    protected $fillable = [
        'cliente_id',
        'data_emissao',
        'status',
    ];


    protected $casts = [
        'status' => pedidosVendaStatus::class
    ];


    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function PedidosVendaItems()
    {
        return $this->hasMany(PedidosVendaItem::class);
    }
}
