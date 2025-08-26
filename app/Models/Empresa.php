<?php

namespace App\Models;

use App\Enum\EmpresaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    /** @use HasFactory<\Database\Factories\EmpresaFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'status'
    ];

    protected $casts = [
        'status' => EmpresaStatus::class,
    ];


    public function filials()
    {
        return $this->hasMany(Filial::class);
    }
}
