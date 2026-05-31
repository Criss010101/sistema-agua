<?php

use App\Http\Controllers\LecturaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetupController;
use App\Models\Administrador;
use Illuminate\Support\Facades\Artisan;
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

// Rutas para setup inicial de administrador (solo si no existe ninguno)
Route::get('/setup-admin', [SetupController::class, 'showForm'])->name('setup.show');
Route::post('/setup-admin', [SetupController::class, 'store'])->name('setup.store');

// RUTA SECRETA PARA REINICIAR TODO EL SISTEMA
Route::get('/limpiar-base-de-datos-secreta', function () {
    // Solo permitimos esto si estamos seguros
    try {
        // migrate:fresh borra todas las tablas y las crea de nuevo
        // --force es necesario para que funcione en producción (Render)
        Artisan::call('migrate:fresh', ['--force' => true]);

        // Ejecutamos los seeders para volver a crear el usuario administrador por defecto
        Artisan::call('db:seed', ['--force' => true]);

        return "La base de datos ha sido limpiada por completo. El administrador ha sido recreado exitosamente.";
    } catch (\Exception $e) {
        return "Error al intentar limpiar la base de datos: " . $e->getMessage();
    }
});

// RUTA SECRETA PARA RESTABLECER SOLO EL ADMINISTRADOR (Sin borrar datos)
Route::get('/restablecer-admin-secreto', function () {
    try {
        // Ejecutamos específicamente el seeder que gestiona el administrador
        Artisan::call('db:seed', [
            '--class' => 'UsuarioAdministradorSeeder',
            '--force' => true
        ]);
        return "El acceso del administrador ha sido restablecido (admin / 123456). Los datos de socios y lecturas NO han sido afectados.";
    } catch (\Exception $e) {
        return "Error al restablecer el administrador: " . $e->getMessage();
    }
});
//               RESTABLECE SOLO USUARIO Y CONTRASEÑA
// RUTA SECRETA PARA PREPARAR ENTREGA (Borra el admin actual para que el cliente cree el suyo)
Route::get('/preparar-entrega-cliente-secreto', function () {
    try {
        
        // Borramos todos los administradores existentes (Socios y lecturas permanecen intactos)
        Administrador::query()->delete();

        return "Sistema preparado para entrega. Se han eliminado las credenciales de administrador. Al intentar entrar al sistema, se le pedirá al cliente que cree su cuenta nueva.";
    } catch (\Exception $e) {
        return "Error al preparar la entrega: " . $e->getMessage();
    }
});
