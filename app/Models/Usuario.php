<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Lectura;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'comunidad_id',
        'codigo_socio',
        'nombre',
        'codigo_medidor',
        'lectura_inicial',
    ];

    protected $casts = [
        'lectura_inicial' => 'decimal:2',
    ];

    public function comunidad(): BelongsTo
    {
        return $this->belongsTo(Comunidad::class, 'comunidad_id');
    }

    public function ultimaLectura(): HasOne
    {
        return $this->hasOne(Lectura::class)->latestOfMany();
    }
}
