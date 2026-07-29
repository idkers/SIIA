<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Casa extends Model
{
    use HasFactory;

    protected $table = 'casas';

    protected $fillable = [
        'dominio_id',
        'nombre',
        'nombre_casa',
        'imagen',
        'color',
        'frase',
        'valores',
        'descripcion',
        'oferta',
        'link',
    ];

    protected function casts(): array
    {
        return [
            'valores' => 'array',
        ];
    }

    public function dominio(): BelongsTo
    {
        return $this->belongsTo(Dominio::class);
    }

    public function resultados(): HasMany
    {
        return $this->hasMany(Resultado::class);
    }
}