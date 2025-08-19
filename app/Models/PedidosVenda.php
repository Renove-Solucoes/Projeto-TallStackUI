<?php

namespace App\Models;

use App\Enum\pedidosVendaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosVenda extends Model
{
    /** @use HasFactory<\Database\Factories\PedidosVendaFactory> */
    use HasFactory;


    protected $fillable = [
        'cliente_id',
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
        'total',
        'status',
    ];


    protected $casts = [
        'status' => pedidosVendaStatus::class
    ];


    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function itens()
    {
        return $this->hasMany(PedidosVendaItem::class);
    }
}
