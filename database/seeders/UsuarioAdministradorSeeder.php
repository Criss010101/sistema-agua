<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Las importaciones DEBEN ir aquí arriba:
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class UsuarioAdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tu función queda limpia y lista para registrarte:
        User::create([
            'name' => 'Cristian',
            'email' => 'admin@admin.com', // Este será tu usuario/correo para loguearte
            'password' => Hash::make('123456'), // Cambia esto por tu contraseña real
        ]);
    }
}