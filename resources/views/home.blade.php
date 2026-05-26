<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Sistema de Agua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background:
                linear-gradient(rgba(244, 246, 250, 0.86), rgba(244, 246, 250, 0.86)),
                url('{{ asset('images/fondo-agua.jpg') }}') center/cover no-repeat fixed;
        }
        .hero-card { background: rgba(255, 255, 255, 0.94); border-radius: 24px; border: none; max-width: 600px; margin: 100px auto; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); backdrop-filter: blur(4px); }
        .btn-search { background-color: #0f172a; color: white; border-radius: 12px; padding: 12px 24px; font-weight: 600; border: none; }
        .btn-search:hover { background-color: #1e293b; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Topbar simulada de tu foto -->
        <div class="d-flex justify-content-between align-items-center py-4">
            <div class="d-flex align-items-center gap-2">
                <span style="font-size: 1.5rem; color: #2563eb;"><i class="fa-solid fa-droplet"></i></span>
                <span class="fw-bold text-dark">Sistema S.A.G.</span>
            </div>
            <a href="{{ route('login') }}" class="btn btn-outline-secondary px-3 py-1.5 fw-semibold" style="border-radius: 10px; font-size: 0.85rem;">
                <i class="fa-solid fa-lock me-1"></i> Iniciar Sesión (Control)
            </a>
        </div>

        <div class="hero-card text-center">
            <div class="mb-3" style="font-size: 3rem; color: #6366f1;"><i class="fa-solid fa-droplet"></i></div>
            <h2 class="fw-bold text-dark mb-1">Consulta de Historial y Pagos</h2>
            <p class="text-muted mb-4">Ingrese el número de su medidor para verificar sus estados de cuenta de agua.</p>

            @if(session('error'))
                <div class="alert alert-danger border-0 p-3 mb-4" style="border-radius: 12px; background-color: #fee2e2; color: #991b1b;">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('comunidad.consulta') }}" method="GET">
                <div class="position-relative mb-3">
                    <input type="text" name="codigo_medidor" class="form-control" placeholder="Ej. MED-5592" required style="border-radius: 12px; padding: 14px; text-align: center; font-weight: 600; font-size: 1.1rem; border: 1px solid #e2e8f0;">
                </div>
                <button type="submit" class="btn btn-search w-100 py-3 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass me-2"></i> Consultar Estado
                </button>
            </form>
        </div>
    </div>
</body>
</html>
