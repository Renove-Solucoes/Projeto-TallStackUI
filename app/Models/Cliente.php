<?php

namespace App\Models;

use App\Enum\ClienteStatus;
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
        'credito_ativo',
        'foto',
        'status'
    ];

    protected $casts = [
        'status' => ClienteStatus::class,
    ];

    public function getTipoPessoaNomeAttribute(): string
    {
        return match ($this->tipo_pessoa) {
            'F' => 'Fisico',
            'J' => 'Juridico',
        };
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_clientes');
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

    public function pedidosVendas()
    {
        return $this->hasMany(PedidosVenda::class);
    }
}
