<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - Sistema de Agua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f6fa;
            color: #0f172a;
            font-family: Arial, sans-serif;
            padding: 18px;
        }
        .password-card {
            width: 100%;
            max-width: 460px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }
        .password-header {
            padding: 24px 26px 12px;
        }
        .password-body {
            padding: 0 26px 26px;
        }
        .form-control {
            border-radius: 9px;
            padding: 11px 12px;
        }
        .btn {
            border-radius: 9px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="password-card">
        <div class="password-header">
            <a href="{{ route('lecturas.index') }}" class="btn btn-link text-decoration-none px-0 mb-2">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver
            </a>
            <h3 class="fw-bold mb-1">Cambiar contraseña</h3>
            <p class="text-secondary mb-0">Administrador: <strong>{{ auth('admin')->user()->usuario }}</strong></p>
        </div>

        <div class="password-body">
            @if(session('success'))
                <div class="alert alert-success border-0">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0">
                    Revisa los datos ingresados.
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Contraseña actual</label>
                    <input type="password" name="password_actual" class="form-control @error('password_actual') is-invalid @enderror" required autocomplete="current-password">
                    @error('password_actual')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Nueva contraseña</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="6" autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required minlength="6" autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="fa-solid fa-key me-1"></i> Guardar nueva contraseña
                </button>
            </form>
        </div>
    </div>
</body>
</html>
