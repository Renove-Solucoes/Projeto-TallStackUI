<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{


    /** @use HasFactory<\Database\Factories\EnderecoFactory> */
    protected $fillable = [
        'cliente_id',
        'descricao',
        'cep',
        'endereco',
        'bairro',
        'numero',
        'cidade',
        'uf',
        'complemento',
        'status',
    ];

    use HasFactory;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
