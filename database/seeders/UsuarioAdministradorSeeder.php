<?php

namespace Database\Seeders;

use App\Models\Administrador;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioAdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrador::firstOrCreate(
            ['usuario' => env('ADMIN_DEFAULT_USER', 'admin')],
            ['password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', '123456'))]
        );
    }
}
