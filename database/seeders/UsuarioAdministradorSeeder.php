<?php

namespace Database\Seeders;

use App\Models\Administrador;
use Illuminate\Database\Seeder;

class UsuarioAdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usamos updateOrCreate para forzar la contraseña indicada.
        // Nota: el modelo `Administrador` tiene el cast `password => 'hashed'`,
        // por lo que debemos pasar la contraseña en texto plano y el modelo
        // la hashará automáticamente.
        Administrador::updateOrCreate(
            ['usuario' => env('ADMIN_DEFAULT_USER', 'admin')],
            ['password' => env('ADMIN_DEFAULT_PASSWORD', '123456')]
        );
    }
}
