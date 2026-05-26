<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { background: #1e293b; border-radius: 20px; width: 100%; max-width: 400px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); border: 1px solid #334155; }
        .form-control { background: #0f172a; border: 1px solid #334155; color: white; border-radius: 10px; padding: 12px; }
        .form-control:focus { background: #0f172a; color: white; border-color: #6366f1; box-shadow: none; }
        .btn-indigo { background-color: #6366f1; color: white; border-radius: 10px; font-weight: 600; border: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <h4 class="fw-bold text-white text-center mb-1">Panel de Control</h4>
        <p class="text-center small mb-4" style="color: #94a3b8;">Acceso autorizado exclusivo para operadores</p>

        @if($errors->any())
            <div class="alert alert-danger border-0 p-2 text-center small mb-3" style="background: #ef4444; color: white; border-radius: 8px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold" style="color: #94a3b8;">Usuario</label>
                <input type="text" name="usuario" class="form-control" placeholder="Ej. admin" required autocomplete="off">
            </div>
            <div class="mb-4">
                <label class="form-label small fw-semibold" style="color: #94a3b8;">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-indigo w-100 py-2.5 mb-2">Ingresar al Sistema</button>
            <a href="{{ route('home') }}" class="btn btn-link w-100 text-center small p-0 text-decoration-none" style="color: #94a3b8;">Volver al inicio</a>
        </form>
    </div>
</body>
</html>