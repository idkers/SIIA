<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dominio extends Model
{
    use HasFactory;

    protected $table = 'dominios';

    protected $fillable = [
        'slug',
        'nombre',
        'nombre_casa',
        'color',
        'imagen',
        'descripcion',
    ];

    public function casas(): HasMany
    {
        return $this->hasMany(Casa::class);
    }

    public function resultados(): HasMany
    {
        return $this->hasMany(Resultado::class);
    }
}