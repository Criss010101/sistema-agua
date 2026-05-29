<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'mes', 'anio', 'lectura_actual', 'consumo_mes', 'total_pagar', 'estado', 'mostrar_mensaje_corte'];

    protected $casts = [
        'mostrar_mensaje_corte' => 'boolean',
    ];

    // Relación: La lectura le pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function getLecturaAnteriorAttribute(): int
    {
        $previous = static::where('usuario_id', $this->usuario_id)
            ->where('created_at', '<', $this->created_at)
            ->orderByDesc('created_at')
            ->first();

        return $previous ? (int) $previous->lectura_actual : 0;
    }

    public function getConsumoAttribute(): int
    {
        return max(0, $this->lectura_actual - $this->lectura_anterior);
    }

    public function getDiasConsumoAttribute(): int
    {
        return \Carbon\Carbon::createFromDate($this->anio, $this->mes, 1)->daysInMonth;
    }
}
