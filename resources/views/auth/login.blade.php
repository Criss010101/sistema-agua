<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            min-height: 100dvh;
            margin: 0;
            padding: 16px;
        }
        .login-card {
            background: #1e293b;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            border: 1px solid #334155;
        }
        .form-control {
            background: #0f172a;
            border: 1px solid #334155;
            color: white;
            border-radius: 10px;
            padding: 12px;
            min-height: 46px;
        }
        .form-control:focus { background: #0f172a; color: white; border-color: #6366f1; box-shadow: none; }
        .btn-indigo {
            background-color: #6366f1;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            min-height: 46px;
        }
        @media (max-width: 575.98px) {
            body {
                padding: 12px;
                align-items: stretch;
            }

            .login-card {
                max-width: 100%;
                padding: 24px 18px;
                border-radius: 18px;
            }

            h4 {
                font-size: 1.25rem;
            }

            .form-control {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h4 class="fw-bold text-white text-center mb-1">Panel de Control</h4>
        <p class="text-center small mb-4" style="color: #94a3b8;">Acceso autorizado exclusivo para operadores</p>

        @php
            $hasAdmin = \App\Models\Administrador::exists();
        @endphp

        @if($errors->any())
            <div class="alert alert-danger border-0 p-2 text-center small mb-3" style="background: #ef4444; color: white; border-radius: 8px;">
                {{ $errors->first() }}
            </div>
        @endif

        @if($hasAdmin)
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color: #94a3b8;">Usuario</label>
                    <input type="text" name="usuario" class="form-control" placeholder="Ej. admin" required autocomplete="username">
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold" style="color: #94a3b8;">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-indigo w-100 py-2.5 mb-2">Ingresar al Sistema</button>
                <a href="{{ route('home') }}" class="btn btn-link w-100 text-center small p-0 text-decoration-none" style="color: #94a3b8;">Volver al inicio</a>
            </form>
        @else
            <div class="alert alert-warning border-0 p-2 text-center small mb-3" style="background: #fcd34d; color: #1f2937; border-radius: 8px;">
                No existe ningún administrador. Crea la cuenta inicial para acceder al panel.
            </div>

            <form action="{{ route('setup.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color: #94a3b8;">Usuario</label>
                    <input type="text" name="usuario" class="form-control" placeholder="Ej. admin" required autocomplete="username" value="admin">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold" style="color: #94a3b8;">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required autocomplete="new-password">
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold" style="color: #94a3b8;">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repite la contraseña" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-indigo w-100 py-2.5 mb-2">Crear Cuenta Administrador</button>
                <a href="{{ route('home') }}" class="btn btn-link w-100 text-center small p-0 text-decoration-none" style="color: #94a3b8;">Volver al inicio</a>
            </form>
        @endif
    </div>
</body>
</html>
