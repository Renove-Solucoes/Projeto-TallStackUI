<?php

namespace App\Models;

use App\Enum\TabelasPrecoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelasPreco extends Model
{
    /** @use HasFactory<\Database\Factories\TabelasPrecoFactory> */
    use HasFactory;

    protected $fillable = [
        'descricao',
        'data_de',
        'data_ate',
        'status',
    ];

    protected $casts = [
        'status' => TabelasPrecoStatus::class
    ];
}
