<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('lecturas.index');
        }

        return back()->withErrors(['usuario' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function showChangePassword()
    {
        return view('auth.cambiar-password');
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'password_actual' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        if (! Hash::check($data['password_actual'], $admin->password)) {
            return back()
                ->withErrors(['password_actual' => 'La contraseña actual no es correcta.'])
                ->onlyInput();
        }

        $admin->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('password.change')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}
