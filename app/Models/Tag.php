<?php

namespace App\Models;

use App\Enum\TagsStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    protected $fillable = [
        'tipo',
        'nome',
        'status',
    ];

    protected $casts = [
        'status' => TagsStatus::class
    ];

    public function cliente()
    {
        return $this->belongsToMany(Cliente::class, 'tags_clientes');
    }
}
