<?php

use App\Http\Controllers\LecturaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetupController;
use App\Models\Administrador;
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
    Route::post('/comunidades/crear', [LecturaController::class, 'storeComunidad'])->name('comunidades.store');
    Route::post('/usuarios/crear', [LecturaController::class, 'storeUsuario'])->name('usuarios.store');
    Route::get('/factura/{id}', [LecturaController::class, 'printFactura'])->name('factura.print');
    Route::post('/facturas-lote', [LecturaController::class, 'generarFacturasLote'])->name('facturas.lote');
    Route::get('/pagos', [LecturaController::class, 'pagosIndex'])->name('pagos.index');
    Route::post('/pagos', [LecturaController::class, 'actualizarPagos'])->name('pagos.actualizar');
    Route::get('/reportes/comunidad', [LecturaController::class, 'reporteComunidad'])->name('reportes.comunidad');
});
use Illuminate\Support\Facades\Artisan;

Route::get('/ejecutar-seeder-secreto', function () {
    try {
        Artisan::call('db:seed');
        return '¡Seeder ejecutado con éxito! Tu usuario ya fue creado en Supabase.';
    } catch (\Exception $e) {
        return 'Hubo un error: ' . $e->getMessage();
    }
});

// RUTA TEMPORAL: restablece/crea el administrador con usuario 'admin' y contraseña '123456'.
// Borra esta ruta después de usarla por seguridad.
Route::get('/fix-admin-pass', function () {
    Administrador::updateOrCreate(
        ['usuario' => 'admin'],
        ['password' => '123456']
    );

    return 'Contraseña del administrador actualizada a 123456. Elimina /fix-admin-pass después.';
});

// Rutas para setup inicial de administrador (solo si no existe ninguno)
Route::get('/setup-admin', [SetupController::class, 'showForm'])->name('setup.show');
Route::post('/setup-admin', [SetupController::class, 'store'])->name('setup.store');
