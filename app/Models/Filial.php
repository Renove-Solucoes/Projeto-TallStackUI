<?php

namespace App\Models;

use App\Enum\FilialStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Filial extends Model
{

    /** @use HasFactory<\Database\Factories\FilialFactory> */
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'empresa_id',
        'razao_social',
        'nome_fantasia',
        'tipo_pessoa',
        'status'

    ];

    public function getEmpresaIdNomeAttribute(): string
    {
        return $this->empresa->nome;
    }

    public function getTipoPessoaNomeAttribute(): string
    {
        return match ($this->tipo_pessoa) {
            'F' => 'Fisico',
            'J' => 'Juridico',
        };
    }


    protected $casts = [
        'status' => FilialStatus::class,
    ];


    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
