<?php

namespace App\Models;

use App\Enum\CategoriasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriaFactory> */
    use HasFactory;

    protected $fillable = [
        'tipo',
        'nome',
        'status',
    ];

    public function getTipoNomeAttribute(): string
    {
        return match ($this->tipo) {
            'C' => 'Cliente',
            'P' => 'Produto',
        };
    }

    protected $casts = [
        'status' => CategoriasStatus::class,
    ];
}
