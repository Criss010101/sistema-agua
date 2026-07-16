<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Agua - Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-main: #f4f6fa;
            --sidebar-bg: #0f172a;
            --sidebar-active: #6366f1;
            --text-muted: #64748b;
            --dark-btn: #0f172a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* BARRA LATERAL */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: #94a3b8;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            padding: 24px 16px;
            transition: left 0.28s ease, opacity 0.28s ease;
        }

        .sidebar-brand {
            padding: 10px 14px;
            margin-bottom: 30px;
            border: 1px solid #1e293b;
            border-radius: 12px;
            background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 100%);
        }

        .sidebar-brand h5 {
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .sidebar-brand span {
            font-size: 0.75rem;
            color: #6366f1;
            display: block;
        }

        .menu-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
            font-weight: 700;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-left: 12px;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-item-link:hover {
            background-color: #1e293b;
            color: #f8fafc;
        }

        .nav-item-link.active {
            background-color: var(--sidebar-active);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .nav-item-link.active::before {
            content: '';
            position: absolute;
            left: -16px;
            top: 12px;
            bottom: 12px;
            width: 4px;
            background-color: #ffffff;
            border-radius: 0 4px 4px 0;
        }

        .btn-add-community {
            width: 100%;
            border: 1px dashed #334155;
            background: rgba(99, 102, 241, 0.08);
            color: #c7d2fe;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            text-align: left;
            transition: all 0.2s ease;
        }

        .btn-add-community:hover {
            background: rgba(99, 102, 241, 0.18);
            border-color: #6366f1;
            color: #ffffff;
        }

        /* CONTENEDOR PRINCIPAL */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-y: auto;
            min-width: 0;
        }

        /* TOPBAR */
        .topbar {
            background-color: #ffffff;
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid #e2e8f0;
            flex-wrap: wrap;
        }

        .hamburger-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border: 1px solid #dbe4f0;
            border-radius: 12px;
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
            flex-shrink: 0;
        }

        .hamburger-btn:hover {
            background: #f8fafc;
        }

        .topbar-title h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-title p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 2px 0 0 0;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #0f172a;
        }

        .user-badge {
            background-color: #e0e7ff;
            color: #4f46e5;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background-color: #818cf8;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* CONTENIDO */
        .content-body {
            padding: 32px 40px;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: flex-end;
            min-width: 0;
        }

        .search-form {
            display: flex;
            width: 100%;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .socio-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-wrapper {
            display: flex;
            gap: 12px;
            margin-bottom: 28px;
        }

        .search-container {
            position: relative;
            flex-grow: 1;
        }

        .search-container i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .search-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background-color: #ffffff;
            font-size: 0.95rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            outline: none;
            transition: all 0.2s;
        }

        .search-input:focus {
            border-color: var(--sidebar-active);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .btn-filter-dark {
            background-color: var(--dark-btn);
            color: white;
            padding: 0 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.2s;
        }

        .btn-filter-dark:hover {
            opacity: 0.9;
            color: white;
        }

        /* TARJETAS DE SOCIOS */
        .socio-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0,0,0,0.01);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .socio-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.04);
        }

        .socio-info-block {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .socio-icon-box {
            width: 48px;
            height: 48px;
            background-color: #eff6ff;
            color: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .socio-details h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .socio-meta {
            display: flex;
            gap: 16px;
            margin-top: 6px;
            font-size: 0.85rem;
            color: var(--text-muted);
            align-items: center;
        }

        .meta-badge {
            background-color: #f1f5f9;
            color: #334155;
            padding: 2px 8px;
            border-radius: 6px;
            font-weight: 600;
        }

        .medidor-badge {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 2px 8px;
            border-radius: 6px;
            font-weight: 600;
            font-family: monospace;
        }

        .socio-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .input-m3 {
            width: 140px;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: 600;
        }

        .btn-boleta {
            background-color: #10b981;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            transition: background 0.2s;
        }

        .btn-boleta:hover {
            background-color: #059669;
        }

        .btn-boleta.registrado {
            background-color: #64748b;
            cursor: not-allowed;
        }

        .btn-multa {
            background-color: #f59e0b;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            transition: background 0.2s;
        }

        .btn-multa:hover {
            background-color: #d97706;
            color: white;
        }

        .corte-option {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
        }

        .corte-option input {
            width: 16px;
            height: 16px;
            accent-color: #ef4444;
        }

        @media (max-width: 991.98px) {
            /* Capa de fondo para cerrar el menú al tocar fuera */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(15, 23, 42, 0.5);
                backdrop-filter: blur(2px);
                z-index: 1100;
            }

            .sidebar-overlay.active {
                display: block;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: -300px;
                width: 260px;
                height: 100vh;
                z-index: 1250;
                display: flex;
                box-shadow: 6px 0 24px rgba(15, 23, 42, 0.22);
                transition: left 0.3s ease-in-out;
            }

            .sidebar.active {
                left: 0;
            }

            .hamburger-btn {
                display: inline-flex;
            }

            .main-content {
                width: 100%;
            }

            .topbar,
            .content-body {
                padding-left: 20px;
                padding-right: 20px;
            }

            .topbar-title h2 {
                font-size: 1.2rem;
            }

            .topbar-actions {
                width: 100%;
                justify-content: space-between;
                align-items: center;
            }

            .user-profile {
                order: -1; /* Mantiene al usuario en una posición prominente si es necesario */
            }

            .search-form {
                flex-wrap: wrap;
            }

            .search-form > div[style*="width: 240px"] {
                width: 100% !important;
                margin-right: 0 !important;
            }

            .search-container {
                width: 100%;
            }

            .btn-filter-dark {
                width: 100%;
                justify-content: center;
                min-height: 44px;
                margin-left: 0 !important;
            }

            .socio-card {
                flex-direction: column;
                align-items: stretch;
                gap: 18px;
            }

            .socio-info-block {
                align-items: flex-start;
            }

            .socio-meta {
                flex-wrap: wrap;
                row-gap: 8px;
            }

            .socio-actions {
                justify-content: stretch;
            }

            .socio-form {
                width: 100%;
            }

            .socio-form .input-m3,
            .socio-form .corte-option,
            .socio-form .btn-boleta,
            .socio-form a.btn-boleta,
            .btn-multa {
                width: 100%;
                justify-content: center;
            }

            .input-m3 {
                width: 100%;
            }

            .corte-option {
                min-height: 44px;
            }
        }

        @media (max-width: 575.98px) {
            body {
                display: block;
            }

            .content-body {
                padding: 16px;
            }

            .topbar {
                padding: 14px 16px;
            }

            .topbar-title h2 {
                flex-wrap: wrap;
                gap: 8px;
            }

            .topbar-actions .btn,
            .topbar-actions .btn-link,
            .topbar-actions form {
                width: 100%;
            }

            .topbar-actions .btn {
                justify-content: center;
            }

            .user-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .socio-card {
                padding: 18px;
                border-radius: 14px;
            }

            .socio-info-block {
                gap: 14px;
            }

            .socio-icon-box {
                width: 44px;
                height: 44px;
                flex-shrink: 0;
            }

            .socio-details h4 {
                font-size: 1rem;
                line-height: 1.25;
                word-break: break-word;
            }

            .socio-meta {
                font-size: 0.8rem;
            }

            .meta-badge,
            .medidor-badge {
                display: inline-flex;
                max-width: 100%;
                word-break: break-word;
            }

            .search-input {
                font-size: 1rem;
            }

            .btn-filter-dark,
            .btn-boleta {
                min-height: 46px;
            }
        }
    </style>
</head>
<body>

    <!-- Overlay para dispositivos móviles -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="sidebar">
        <div class="sidebar-brand">
            <h5>Sistema S.A.G.</h5>
            <span>Gestión Comercial de Agua</span>
        </div>
        
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-item-link"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            
            <div class="menu-section-title">Servicios Públicos</div>
            <a href="{{ route('lecturas.index') }}" class="nav-item-link active"><i class="fa-solid fa-droplet"></i> Registro de Lecturas</a>
            
            <div class="menu-section-title">Comunidades</div>
            <button type="button" class="btn-add-community" data-bs-toggle="modal" data-bs-target="#modalComunidad">
                <i class="fa-solid fa-plus"></i> A&ntilde;adir Comunidad
            </button>
            <a href="{{ route('lecturas.index') }}" class="nav-item-link {{ !$comunidadSeleccionada ? 'fw-bold text-white' : '' }}">
                <i class="fa-solid fa-globe"></i> Mostrar Todas
            </a>
            @foreach($comunidades as $comunidad)
                <a href="{{ route('lecturas.index', ['comunidad_id' => $comunidad->id]) }}" 
                   class="nav-item-link {{ $comunidadSeleccionada == $comunidad->id ? 'fw-bold text-white' : '' }}" style="font-size: 0.85rem; padding-left: 28px;">
                    🏢 {{ $comunidad->nombre }}
                </a>
            @endforeach

            <div class="menu-section-title">Sistema</div>
            <a href="{{ route('password.change') }}" class="nav-item-link">
                <i class="fa-solid fa-key"></i> Contraseña
            </a>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="nav-item-link w-100 border-0 bg-transparent text-start" style="cursor: pointer;">
                    <i class="fa-solid fa-right-from-bracket text-danger"></i> <span class="text-danger">Salir</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <button type="button" class="hamburger-btn" id="menuToggle" aria-label="Abrir menú">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="topbar-title">
                <h2>Lecturas <span class="badge bg-dark align-middle" style="font-size: 0.65rem; border-radius: 6px; background-color: #1e293b !important;">MEDICIÓN</span></h2>
                <p>Gestión de lecturas y control de consumo mensual</p>
            </div>
            <div class="topbar-actions">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-primary fw-semibold px-3 py-1.5" style="border-radius: 8px; font-size: 0.85rem;" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                        ➕ Nuevo Socio
                    </button>
                    <button type="button" class="btn btn-outline-success fw-semibold px-3 py-1.5" style="border-radius: 8px; font-size: 0.85rem;" data-bs-toggle="modal" data-bs-target="#modalFacturasLote">
                        🖨️ Generar Boletas
                    </button>
                    <a href="{{ route('pagos.index', ['comunidad_id' => $comunidadSeleccionada]) }}" class="btn btn-outline-warning fw-semibold px-3 py-1.5" style="border-radius: 8px; font-size: 0.85rem;">
                        ✅ Pagos
                    </a>
                </div>

                <div class="user-profile">
                    <span class="user-name d-none d-sm-inline">{{ auth('admin')->user()->usuario }}</span>
                    <div class="user-avatar" title="{{ auth('admin')->user()->usuario }}">
                        {{ strtoupper(substr(auth('admin')->user()->usuario, 0, 2)) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm p-3 mb-4" style="border-radius: 12px; background-color: #dcfce7; color: #15803d;">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm p-3 mb-4" style="border-radius: 12px;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <div class="search-wrapper">
                <form action="{{ route('lecturas.index') }}" method="GET" class="search-form">
                    <div class="d-flex gap-2">
                        <select name="comunidad_id" class="form-select" style="border-radius: 12px; padding: 10px; background:white; color:black;">
                            <option value="">Todas las comunidades</option>
                            @foreach($comunidades as $c)
                                <option value="{{ $c->id }}" {{ (string)$comunidadSeleccionada === (string)$c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>

                        <select name="mes" class="form-select" style="border-radius: 12px; width: 130px;">
                            @php
                                $mesesNombres = [1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'];
                            @endphp
                            @foreach($mesesNombres as $mNum => $mNom)
                                <option value="{{ $mNum }}" {{ $mesActual == $mNum ? 'selected' : '' }}>{{ $mNom }}</option>
                            @endforeach
                        </select>

                        <select name="anio" class="form-select" style="border-radius: 12px; width: 100px;">
                            @for($i = now()->year; $i >= 2024; $i--)
                                <option value="{{ $i }}" {{ $anioActual == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="search-container flex-grow-1">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="q" class="search-input" placeholder="Buscar socio por nombre, medidor o código..." value="{{ $search ?? '' }}">
                    </div>
                    <button type="submit" class="btn-filter-dark ms-3">
                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                    </button>
                </form>
            </div>

            <div>
                @forelse($usuarios as $usuario)
                    <div class="socio-card">
                        <div class="socio-info-block">
                            <div class="socio-icon-box">
                                <i class="fa-solid fa-user-check"></i>
                            </div>
                            <div class="socio-details">
                                <h4>{{ $usuario->nombre }}</h4>
                                <div class="socio-meta">
                                    <span>Socio: <strong class="text-dark">#{{ $usuario->codigo_socio }}</strong></span>
                                    <span>Comunidad: <span class="meta-badge">📍 {{ $usuario->comunidad->nombre ?? 'Sin especificar' }}</span></span>
                                </div>
                            </div>
                        </div>

                        <div class="socio-actions">
                            @php
                                $yaRegistrado = $usuario->ultimaLectura && 
                                               $usuario->ultimaLectura->mes == $mesActual && 
                                               $usuario->ultimaLectura->anio == $anioActual;
                            @endphp
                            <form action="{{ route('lecturas.store') }}" method="POST" class="socio-form" id="form-socio-{{ $usuario->id }}">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
                                <input type="hidden" name="mes" value="{{ $mesActual }}">
                                <input type="hidden" name="anio" value="{{ $anioActual }}">
                                <input type="number" name="lectura_actual" class="input-m3" placeholder="M³ Actuales" required min="0" inputmode="numeric">
                                <input type="number" name="meses_deuda_manual" class="input-m3" placeholder="Meses Deuda" min="0" style="width: 100px;" value="{{ $yaRegistrado ? $usuario->ultimaLectura->meses_deuda_manual : '' }}">
                                <button type="submit" class="btn-boleta {{ $yaRegistrado ? 'bg-secondary' : '' }}">
                                    <i class="fa-solid {{ $yaRegistrado ? 'fa-circle-check' : 'fa-file-invoice-dollar' }} me-1"></i> 
                                    {{ $yaRegistrado ? 'Re-generar' : 'Generar Boleta' }}
                                </button>
                            </form>

                            <button type="button" class="btn btn-outline-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario" data-usuario-id="{{ $usuario->id }}" data-usuario-nombre="{{ $usuario->nombre }}" style="border-radius: 8px; padding: 0.5rem 0.9rem;">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Editar
                            </button>

                            <button type="button" class="btn-multa" data-bs-toggle="modal" data-bs-target="#modalMulta" data-usuario-id="{{ $usuario->id }}" data-usuario-nombre="{{ $usuario->nombre }}">
                                <i class="fa-solid fa-scale-balanced me-1"></i> Multa
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-5 bg-white shadow-sm" style="border-radius: 16px;">
                        <i class="fa-solid fa-folder-open text-muted mb-2" style="font-size: 2.5rem;"></i>
                        <p class="text-muted fw-medium m-0">No se encontraron socios en esta sección.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalComunidad" tabindex="-1" aria-labelledby="modalComunidadLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark" id="modalComunidadLabel">
                        <i class="fa-solid fa-building me-2 text-primary"></i>A&ntilde;adir Comunidad
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('comunidades.store') }}" method="POST">
                    @csrf
                    <div class="modal-body px-4 pb-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold small">Nombre de la comunidad</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej. Nueva Comunidad" required maxlength="255" style="border-radius: 8px; background:white; color:black;">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light px-4 py-3" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                        <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
                        <button type="submit" class="btn btn-primary fw-semibold" style="border-radius: 8px; background-color: var(--sidebar-active); border: none;">Guardar Comunidad</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark" id="modalUsuarioLabel">✨ Registrar Nuevo Socio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <div class="modal-body px-4 pb-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold small">Nombre Completo del Socio</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej. Cristian Olivera" required style="border-radius: 8px; background:white; color:black;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold small">Comunidad</label>
                            <select name="comunidad_id" id="comunidadSocioSelect" class="form-select" required style="border-radius: 8px; background:white; color:black;">
                                <option value="" {{ $comunidadSeleccionada ? '' : 'selected' }} disabled>-- Selecciona una comunidad --</option>
                                @foreach($comunidades as $comunidad)
                                    <option value="{{ $comunidad->id }}" {{ (string) $comunidadSeleccionada === (string) $comunidad->id ? 'selected' : '' }}>{{ $comunidad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary fw-semibold small">C&oacute;digo de Socio</label>
                                <input type="text" id="codigoSocioAutomatico" class="form-control" value="Autom&aacute;tico" readonly style="border-radius: 8px; background:#f8fafc; color:#475569;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary fw-semibold small">Código del Medidor</label>
                                <input type="text" name="codigo_medidor" class="form-control" placeholder="Ej. MED-001" required style="border-radius: 8px; background:white; color:black;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lectura Inicial (m³)</label>
                            <input type="number" name="lectura_inicial" class="form-control" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light px-4 py-3" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                        <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
                        <button type="submit" class="btn btn-primary fw-semibold" style="border-radius: 8px; background-color: var(--sidebar-active); border: none;">Guardar Socio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark" id="modalEditarUsuarioLabel">✏️ Editar Nombre del Socio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarUsuario" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 pb-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold small">Nombre Completo del Socio</label>
                            <input type="text" name="nombre" id="editarUsuarioNombre" class="form-control" placeholder="Ej. Cristian Olivera" required style="border-radius: 8px; background:white; color:black;">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light px-4 py-3" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                        <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
                        <button type="submit" class="btn btn-primary fw-semibold" style="border-radius: 8px; background-color: var(--sidebar-active); border: none;">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFacturasLote" tabindex="-1" aria-labelledby="modalFacturasLoteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark" id="modalFacturasLoteLabel">📄 Generar Boletas en Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('facturas.lote') }}" method="POST">
                    @csrf
                    <div class="modal-body px-4 pb-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold small">Seleccionar Comunidad</label>
                            <select name="comunidad_id" class="form-select" required style="border-radius: 8px; background:white; color:black;">
                                <option value="" selected disabled>-- Selecciona una comunidad --</option>
                                @foreach($comunidades as $comunidad)
                                    <option value="{{ $comunidad->id }}">{{ $comunidad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <label class="form-label text-secondary fw-semibold small">Mes de las Boletas</label>
                                <select name="mes" class="form-select" required style="border-radius: 8px; background:white; color:black;">
                                    @php
                                        $mesesFactura = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];
                                    @endphp
                                    @foreach($mesesFactura as $numeroMes => $nombreMes)
                                        <option value="{{ $numeroMes }}" {{ now()->month == $numeroMes ? 'selected' : '' }}>{{ $nombreMes }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label text-secondary fw-semibold small">Año</label>
                                <input type="number" name="anio" class="form-control" value="{{ now()->year }}" min="2000" max="2100" required style="border-radius: 8px; background:white; color:black;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold small">Día de Cobranza</label>
                            <input type="text" name="fecha_cobranza" class="form-control" placeholder="Ej. JUEVES 6 DE MARZO del 2026" required style="border-radius: 8px; background:white; color:black;">
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light px-4 py-3" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                        <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
                        <button type="submit" class="btn btn-primary fw-semibold" style="border-radius: 8px; background-color: var(--sidebar-active); border: none;">Generar Boletas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Multas -->
    <div class="modal fade" id="modalMulta" tabindex="-1" aria-labelledby="modalMultaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark" id="modalMultaLabel">⚖️ Registrar Multa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <input type="hidden" name="usuario_id" id="multa_usuario_id">
                    <p class="text-secondary small mb-3">Socio: <strong id="multa_socio_nombre" class="text-dark"></strong></p>
                    
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold small">Seleccione los motivos (50 Bs c/u)</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input multa-check" type="checkbox" name="motivo[]" id="multaCorte" value="Multa por corte">
                            <label class="form-check-label" for="multaCorte">
                                Multa por corte 
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input multa-check" type="checkbox" name="motivo[]" id="multaAsamblea" value="Falta asamblea">
                            <label class="form-check-label" for="multaAsamblea">
                                Falta asamblea
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary fw-semibold small">Fecha de la multa</label>
                        <input type="date" id="fecha_multa_input" class="form-control" style="border-radius: 8px;" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light px-4 py-3" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
                    <button type="button" id="btnRegistrarMulta" class="btn btn-warning fw-semibold text-white" style="border-radius: 8px;">Aplicar Multas</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const siguienteCodigoPorComunidad = @json($comunidades->mapWithKeys(fn ($comunidad) => [
            $comunidad->id => (int) ($siguienteCodigoPorComunidad[$comunidad->id] ?? 1),
        ]));

        document.addEventListener('DOMContentLoaded', function () {
            if (window.location.hash === '#modalUsuario' || window.location.hash === '#modalFacturasLote' || window.location.hash === '#modalComunidad') {
                const modalElement = document.querySelector(window.location.hash);
                if (modalElement) {
                    new bootstrap.Modal(modalElement).show();
                }
            }

            const comunidadSelect = document.getElementById('comunidadSocioSelect');
            const codigoSocioInput = document.getElementById('codigoSocioAutomatico');
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.querySelector('.sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Lógica para pasar datos al modal de Multa
            const modalMulta = document.getElementById('modalMulta');
            if (modalMulta) {
                modalMulta.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const usuarioId = button.getAttribute('data-usuario-id');
                    const usuarioNombre = button.getAttribute('data-usuario-nombre');
                    
                    document.getElementById('multa_usuario_id').value = usuarioId;
                    document.getElementById('multa_socio_nombre').textContent = usuarioNombre;
                    // Limpiar selecciones previas
                    modalMulta.querySelectorAll('.multa-check').forEach(cb => cb.checked = false);
                });
            }

            const modalEditarUsuario = document.getElementById('modalEditarUsuario');
            if (modalEditarUsuario) {
                modalEditarUsuario.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const usuarioId = button.getAttribute('data-usuario-id');
                    const usuarioNombre = button.getAttribute('data-usuario-nombre');
                    const formEditar = document.getElementById('formEditarUsuario');
                    const nombreInput = document.getElementById('editarUsuarioNombre');

                    if (formEditar && nombreInput && usuarioId) {
                        nombreInput.value = usuarioNombre || '';
                        formEditar.action = `/usuarios/${usuarioId}`;
                    }
                });
            }

            // Lógica para sincronizar las multas con el formulario de la boleta
            const btnRegistrarMulta = document.getElementById('btnRegistrarMulta');
            if (btnRegistrarMulta) {
                btnRegistrarMulta.addEventListener('click', function() {
                    const userId = document.getElementById('multa_usuario_id').value;
                    const form = document.getElementById('form-socio-' + userId);
                    
                    // Eliminar inputs de multas previos si existen en este formulario
                    form.querySelectorAll('input[name="multas[]"]').forEach(i => i.remove());

                    // Obtener checks seleccionados
                    const checkboxes = document.querySelectorAll('#modalMulta .multa-check:checked');
                    checkboxes.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'multas[]';
                        input.value = cb.value;
                        form.appendChild(input);
                    });

                    // Actualizar visualmente el botón de multa del socio
                    const btnSocio = document.querySelector(`button[data-usuario-id="${userId}"].btn-multa`);
                    if (checkboxes.length > 0) {
                        btnSocio.style.backgroundColor = '#b45309';
                        btnSocio.innerHTML = `<i class="fa-solid fa-check"></i> Multa (${checkboxes.length})`;
                    } else {
                        btnSocio.style.backgroundColor = '#f59e0b';
                        btnSocio.innerHTML = `<i class="fa-solid fa-scale-balanced me-1"></i> Multa`;
                    }

                    bootstrap.Modal.getInstance(modalMulta).hide();
                });
            }

            const toggleMenu = () => {
                sidebar?.classList.toggle('active');
                sidebarOverlay?.classList.toggle('active');
            };

            menuToggle?.addEventListener('click', toggleMenu);
            sidebarOverlay?.addEventListener('click', toggleMenu);

            document.querySelectorAll('.sidebar a, .sidebar button').forEach((element) => {
                element.addEventListener('click', () => {
                    if (window.innerWidth <= 991.98) {
                        sidebar?.classList.remove('active');
                        sidebarOverlay?.classList.remove('active');
                    }
                });
            });

            const actualizarCodigoSocio = () => {
                if (!comunidadSelect || !codigoSocioInput) {
                    return;
                }

                const comunidadId = comunidadSelect.value;
                codigoSocioInput.value = comunidadId
                    ? `#${siguienteCodigoPorComunidad[comunidadId] ?? 1}`
                    : 'Automático';
            };

            actualizarCodigoSocio();
            comunidadSelect?.addEventListener('change', actualizarCodigoSocio);
        });
    </script>
</body>
</html>
