<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrador extends Authenticatable
{
    protected $table = 'administradores';

    // ASÍ LE DAMOS PERMISO DE GUARDAR ESTOS CAMPOS MASIVAMENTE
    protected $fillable = ['usuario', 'password'];
}