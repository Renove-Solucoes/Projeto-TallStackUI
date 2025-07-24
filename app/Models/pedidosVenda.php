<?php

namespace App\Models;

use App\Enum\pedidosVendaStatus;
use Illuminate\Database\Eloquent\Model;

class pedidosVenda extends Model
{
    protected $fillable = [
        'cliente_id',
        'data',
        'status',
        'total'
    ];


    protected $casts = [
        'status' => pedidosVendaStatus::class
    ];


    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pedidosVendaProdutos()
    {
        return $this->hasMany(pedidosVendaProdutos::class);
    }
}
