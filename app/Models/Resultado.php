<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resultado extends Model
{
    use HasFactory;

    protected $table = 'resultados';

    protected $fillable = [
        'user_id',
        'dominio_id',
        'casa_id',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dominio(): BelongsTo
    {
        return $this->belongsTo(Dominio::class, 'dominio_id');
    }

    public function casa(): BelongsTo
    {
        return $this->belongsTo(Casa::class, 'casa_id');
    }
}