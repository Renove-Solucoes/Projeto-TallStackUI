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
        'nome',
        'status',
    ];

    protected $casts = [
        'status' => CategoriasStatus::class,
    ];
}
