<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    // Mostrar formulario de creación inicial de administrador
    public function showForm()
    {
        if (Administrador::count() > 0) {
            return redirect()->route('login')->with('error', 'El administrador ya fue creado.');
        }

        return view('setup');
    }

    // Guardar el administrador inicial
    public function store(Request $request)
    {
        if (Administrador::count() > 0) {
            return redirect()->route('login')->with('error', 'El administrador ya fue creado.');
        }

        $data = $request->validate([
            'usuario' => 'required|string|max:50|unique:administradores,usuario',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Administrador::create([
            'usuario' => $data['usuario'],
            'password' => $data['password'], // el modelo usa cast hashed
        ]);

        return redirect()->route('login')->with('success', 'Administrador creado correctamente. Inicia sesión.');
    }
}
