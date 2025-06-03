<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory;
    use Notifiable;


    protected $fillable = [
        'cpf_cnpj',
        'nome',
        'tipo_pessoa',
        'email',
        'telefone',
        'nascimento',
        'credito',
        'status'
    ];
}
