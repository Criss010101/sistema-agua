<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Sistema S.A.G.</title>
    <!-- Fuentes y Librerías -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-blue: #2563eb;
            --dark-navy: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #071e3d 0%, #1e3a8a 100%);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* --- FONDO ANIMADO DE OLAS --- */
        .ocean { 
            height: 100%; width: 100%;
            position: absolute; bottom: 0; left: 0;
            background: transparent; z-index: 1; pointer-events: none;
        }

        .wave {
            background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/85486/wave.svg') repeat-x; 
            position: absolute; bottom: -5px; width: 6400px; height: 198px;
            animation: wave 12s cubic-bezier(0.36, 0.45, 0.63, 0.53) infinite;
            transform: translate3d(0, 0, 0);
            opacity: 0.3;
        }

        .wave:nth-of-type(2) {
            bottom: -15px;
            animation: wave 15s cubic-bezier(0.36, 0.45, 0.63, 0.53) -0.125s infinite, swell 7s ease -1.25s infinite;
            opacity: 0.2;
        }

        @keyframes wave {
            0% { margin-left: 0; }
            100% { margin-left: -1600px; }
        }

        @keyframes swell {
            0%, 100% { transform: translate3d(0, -25px, 0); }
            50% { transform: translate3d(0, 5px, 0); }
        }

        /* --- CONTENEDOR PRINCIPAL --- */
        .main-content {
            position: relative;
            z-index: 2; /* Por encima de las olas */
            width: 100%;
        }

        /* --- GLASSMORPHISM CARD --- */
        .hero-card { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px);
            border-radius: 32px; 
            border: 1px solid rgba(255, 255, 255, 0.4); 
            max-width: 550px; 
            margin: 60px auto; 
            padding: 50px 40px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease;
        }

        .hero-card:hover {
            transform: translateY(-5px);
        }

        /* --- ELEMENTOS DE DISEÑO --- */
        .droplet-icon {
            font-size: 3.5rem;
            background: linear-gradient(135deg, #6366f1, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
            margin-bottom: 20px;
        }

        .btn-search { 
            background: var(--dark-navy); 
            color: white; 
            border-radius: 16px; 
            padding: 16px; 
            font-weight: 700; 
            border: none;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-search:hover { 
            background: #1e293b; 
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: white;
        }

        .form-control-custom {
            border-radius: 16px; 
            padding: 16px; 
            text-align: center; 
            font-weight: 600; 
            font-size: 1.1rem; 
            border: 2px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            background: #fff;
        }

        /* Topbar adaptada */
        .top-bar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-login-top {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-login-top:hover {
            background: white;
            color: var(--dark-navy);
        }
    </style>
</head>
<body>

    <!-- Olas Animadas -->
    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <div class="main-content container">
        <!-- Topbar mejorada -->
        <div class="d-flex justify-content-between align-items-center py-4">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                    <span style="font-size: 1.2rem; color: #2563eb;"><i class="fa-solid fa-droplet"></i></span>
                </div>
                <div class="d-flex flex-column">
                    <span class="fw-bold text-white shadow-text">Sistema S.A.G.</span>
                    <small class="text-white-50" style="font-size:0.78rem">Creado por Cristian Olivera 2026</small>
                </div>
            </div>
            <a href="{{ route('login') }}" class="btn btn-login-top px-4 py-2 fw-semibold shadow-sm">
                <i class="fa-solid fa-lock me-2"></i> Iniciar Sesión (Control)
            </a>
        </div>

        <!-- Card Principal -->
        <div class="hero-card text-center">
            <div class="droplet-icon">
                <i class="fa-solid fa-droplet"></i>
            </div>
            
            <h2 class="fw-bold text-dark mb-2">Consulta de Historial y Pagos</h2>
            <p class="text-muted mb-4 px-3">Ingrese el número de su medidor o su código de socio para verificar sus estados de cuenta de agua.</p>

            @if(session('error'))
                <div class="alert border-0 p-3 mb-4" style="border-radius: 16px; background-color: #fee2e2; color: #991b1b;">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('comunidad.consulta') }}" method="GET">
                <div class="mb-4">
                    <input type="text" 
                           name="codigo_medidor" 
                           class="form-control form-control-custom" 
                           placeholder="Ej. MED-5592 o 123" 
                           required>
                </div>
                
                <button type="submit" class="btn btn-search w-100 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass me-2"></i> CONSULTAR ESTADO
                </button>
            </form>
            
            <div class="mt-4">
                <small class="text-muted"><i class="fa-solid fa-shield-halved me-1"></i> Consulta segura y rápida</small>
            </div>
        </div>
    </div>

</body>
</html>