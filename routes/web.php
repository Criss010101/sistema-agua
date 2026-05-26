<?php

use App\Http\Controllers\LecturaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// --- VISTAS PÚBLICAS (Para los Socios) ---
Route::get('/', [LecturaController::class, 'home'])->name('home');
Route::get('/consulta', [LecturaController::class, 'consultarMedidor'])->name('comunidad.consulta');

// --- LOGIN DEL ADMINISTRADOR ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- PANEL PRIVADO (Solo si el Administrador inició sesión) ---
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/cambiar-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/cambiar-password', [AuthController::class, 'changePassword'])->name('password.update');
    Route::get('/dashboard', [LecturaController::class, 'dashboard'])->name('dashboard');
    Route::get('/lecturas', [LecturaController::class, 'index'])->name('lecturas.index');
    Route::post('/lecturas/store', [LecturaController::class, 'store'])->name('lecturas.store');
    Route::post('/usuarios/crear', [LecturaController::class, 'storeUsuario'])->name('usuarios.store');
    Route::get('/factura/{id}', [LecturaController::class, 'printFactura'])->name('factura.print');
    Route::post('/facturas-lote', [LecturaController::class, 'generarFacturasLote'])->name('facturas.lote');
    Route::get('/pagos', [LecturaController::class, 'pagosIndex'])->name('pagos.index');
    Route::post('/pagos', [LecturaController::class, 'actualizarPagos'])->name('pagos.actualizar');
    Route::get('/reportes/comunidad', [LecturaController::class, 'reporteComunidad'])->name('reportes.comunidad');
});
