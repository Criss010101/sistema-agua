<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Agua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-main: #f4f6fa;
            --sidebar-bg: #0f172a;
            --sidebar-active: #6366f1;
            --text-muted: #64748b;
        }
        body {
            margin: 0;
            height: 100vh;
            overflow: hidden;
            display: flex;
            background: var(--bg-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
        }
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: #94a3b8;
            padding: 24px 16px;
            flex-shrink: 0;
        }
        .sidebar-brand {
            padding: 10px 14px;
            margin-bottom: 30px;
            border: 1px solid #1e293b;
            border-radius: 12px;
            background: linear-gradient(135deg, #1e1b4b 0%, #0f172a 100%);
        }
        .sidebar-brand h5 {
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0;
        }
        .sidebar-brand span {
            color: #6366f1;
            font-size: 0.75rem;
        }
        .menu-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
            font-weight: 800;
            margin: 22px 0 10px;
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
            font-weight: 600;
            border-radius: 10px;
        }
        .nav-item-link:hover,
        .nav-item-link.active {
            background: var(--sidebar-active);
            color: #fff;
        }
        .main-content {
            flex: 1;
            height: 100vh;
            overflow-y: auto;
        }
        .topbar {
            background: #fff;
            padding: 16px 40px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .content-body {
            padding: 28px 40px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
        }
        .stat-card,
        .panel {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }
        .stat-card {
            padding: 18px;
        }
        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            color: #fff;
        }
        .stat-label {
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
        }
        .stat-value {
            font-size: 1.65rem;
            font-weight: 800;
            margin: 2px 0 0;
        }
        .panel {
            padding: 18px;
        }
        .panel-title {
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 14px;
        }
        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }
        .table th {
            color: var(--text-muted);
            font-size: 0.74rem;
            text-transform: uppercase;
        }
        .status-pill {
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
        }
        .status-paid {
            background: #dcfce7;
            color: #15803d;
        }
        .status-pending {
            background: #fee2e2;
            color: #b91c1c;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }
        .quick-actions a,
        .quick-actions button {
            border-radius: 10px;
            font-weight: 800;
            padding: 12px;
        }
        @media (max-width: 1000px) {
            body { overflow: auto; height: auto; }
            .sidebar { display: none; }
            .main-content { height: auto; }
            .stat-grid,
            .quick-actions { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 650px) {
            .topbar,
            .content-body { padding-left: 18px; padding-right: 18px; }
            .stat-grid,
            .quick-actions { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @php
        $meses = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];
    @endphp

    <aside class="sidebar">
        <div class="sidebar-brand">
            <h5>Sistema S.A.G.</h5>
            <span>Gestión Comercial de Agua</span>
        </div>

        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-item-link active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>

            <div class="menu-section-title">Servicios Públicos</div>
            <a href="{{ route('lecturas.index') }}" class="nav-item-link"><i class="fa-solid fa-droplet"></i> Registro de Lecturas</a>
            <a href="{{ route('pagos.index') }}" class="nav-item-link"><i class="fa-solid fa-money-bill-wave"></i> Pagos</a>
        </div>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <div>
                <h2 class="fw-bold mb-1">Dashboard</h2>
                <p class="text-secondary mb-0">Resumen general de socios, boletas, pagos y consumo.</p>
            </div>

            <form action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2 align-items-center">
                <select name="mes" class="form-select form-select-sm fw-semibold">
                    @foreach($meses as $numeroMes => $nombreMes)
                        <option value="{{ $numeroMes }}" {{ $mesSeleccionado === $numeroMes ? 'selected' : '' }}>{{ $nombreMes }}</option>
                    @endforeach
                </select>
                <input type="number" name="anio" class="form-control form-control-sm fw-semibold" min="2000" max="2100" value="{{ $anioSeleccionado }}" style="width: 96px;">
                <button class="btn btn-dark btn-sm fw-bold" type="submit">Ver</button>
                <a href="{{ route('password.change') }}" class="btn btn-outline-secondary btn-sm fw-bold">
                    <i class="fa-solid fa-key"></i>
                </a>
            </form>
        </div>

        <div class="content-body">
            <div class="quick-actions mb-4">
                <a href="{{ route('lecturas.index') }}" class="btn btn-primary"><i class="fa-solid fa-droplet me-1"></i> Registrar Lectura</a>
                <a href="{{ route('lecturas.index') }}#modalFacturasLote" class="btn btn-success"><i class="fa-solid fa-print me-1"></i> Generar Facturas</a>
                <a href="{{ route('pagos.index', ['mes' => $mesSeleccionado, 'anio' => $anioSeleccionado]) }}" class="btn btn-warning"><i class="fa-solid fa-check-to-slot me-1"></i> Registrar Pagos</a>
                <a href="{{ route('lecturas.index') }}#modalUsuario" class="btn btn-outline-dark"><i class="fa-solid fa-user-plus me-1"></i> Nuevo Socio</a>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalReporteComunidad">
                    <i class="fa-solid fa-table me-1"></i> Lista Comunidad
                </button>
            </div>

            <div class="stat-grid mb-4">
                <div class="stat-card">
                    <div class="stat-icon" style="background:#2563eb;"><i class="fa-solid fa-users"></i></div>
                    <div class="stat-label">Total de socios</div>
                    <div class="stat-value">{{ $stats['total_socios'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#0891b2;"><i class="fa-solid fa-file-invoice"></i></div>
                    <div class="stat-label">Boletas del mes</div>
                    <div class="stat-value">{{ $stats['boletas_mes'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#16a34a;"><i class="fa-solid fa-sack-dollar"></i></div>
                    <div class="stat-label">Pagado</div>
                    <div class="stat-value">Bs. {{ number_format($stats['total_recaudado'], 2) }}</div>
                    <div class="text-secondary small">{{ $stats['pagadas'] }} factura(s)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#dc2626;"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <div class="stat-label">Pendiente</div>
                    <div class="stat-value">Bs. {{ number_format($stats['total_pendiente'], 2) }}</div>
                    <div class="text-secondary small">{{ $stats['pendientes'] }} factura(s)</div>
                </div>
            </div>

            <div class="stat-grid mb-4">
                <div class="stat-card">
                    <div class="stat-label">Comunidades</div>
                    <div class="stat-value">{{ $stats['total_comunidades'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Consumo total</div>
                    <div class="stat-value">{{ $stats['consumo_mes'] }} m³</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Periodo</div>
                    <div class="stat-value">{{ $meses[$mesSeleccionado] ?? '' }}</div>
                    <div class="text-secondary small">{{ $anioSeleccionado }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Avance de pago</div>
                    @php
                        $avance = $stats['boletas_mes'] > 0 ? round(($stats['pagadas'] / $stats['boletas_mes']) * 100) : 0;
                    @endphp
                    <div class="stat-value">{{ $avance }}%</div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="panel">
                        <div class="panel-title">Socios y pagos por comunidad</div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Comunidad</th>
                                        <th>Socios</th>
                                        <th>Boletas</th>
                                        <th>Pagadas</th>
                                        <th>Pendientes</th>
                                        <th>Deuda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($resumenComunidades as $comunidad)
                                        <tr>
                                            <td class="fw-bold">{{ $comunidad['nombre'] }}</td>
                                            <td>{{ $comunidad['socios'] }}</td>
                                            <td>{{ $comunidad['boletas'] }}</td>
                                            <td class="text-success fw-bold">{{ $comunidad['pagadas'] }}</td>
                                            <td class="text-danger fw-bold">{{ $comunidad['pendientes'] }}</td>
                                            <td>Bs. {{ number_format($comunidad['deuda'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="panel">
                        <div class="panel-title">Pagos pendientes</div>
                        @forelse($pendientesDetalle as $lectura)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <div class="fw-bold">{{ $lectura->usuario->nombre }}</div>
                                    <div class="text-secondary small">{{ $lectura->usuario->comunidad->nombre }} · Socio #{{ $lectura->usuario->codigo_socio }}</div>
                                </div>
                                <strong>Bs. {{ number_format($lectura->total_pagar, 2) }}</strong>
                            </div>
                        @empty
                            <p class="text-secondary mb-0">No hay pagos pendientes en este periodo.</p>
                        @endforelse
                    </div>
                </div>

                <div class="col-12">
                    <div class="panel">
                        <div class="panel-title">Últimas boletas generadas</div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Socio</th>
                                        <th>Comunidad</th>
                                        <th>Consumo</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ultimasBoletas as $lectura)
                                        <tr>
                                            <td>{{ $lectura->created_at->format('d/m/Y') }}</td>
                                            <td class="fw-bold">{{ $lectura->usuario->nombre }}</td>
                                            <td>{{ $lectura->usuario->comunidad->nombre }}</td>
                                            <td>{{ $lectura->consumo_mes }} m³</td>
                                            <td>Bs. {{ number_format($lectura->total_pagar, 2) }}</td>
                                            <td>
                                                <span class="status-pill {{ $lectura->estado === 'pagado' ? 'status-paid' : 'status-pending' }}">
                                                    {{ $lectura->estado === 'pagado' ? 'Pagado' : 'Pendiente' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-secondary py-4">Todavía no hay boletas generadas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modalReporteComunidad" tabindex="-1" aria-labelledby="modalReporteComunidadLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="modalReporteComunidadLabel">
                        <i class="fa-solid fa-table me-1"></i> Imprimir Lista por Comunidad
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form action="{{ route('reportes.comunidad') }}" method="GET" target="_blank">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">Comunidad</label>
                            <select name="comunidad_id" class="form-select" required>
                                @foreach($comunidades as $comunidad)
                                    <option value="{{ $comunidad->id }}">{{ $comunidad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-7 mb-3">
                                <label class="form-label fw-semibold text-secondary small">Mes</label>
                                <select name="mes" class="form-select" required>
                                    @foreach($meses as $numeroMes => $nombreMes)
                                        <option value="{{ $numeroMes }}" {{ $mesSeleccionado === $numeroMes ? 'selected' : '' }}>{{ $nombreMes }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label fw-semibold text-secondary small">Año</label>
                                <input type="number" name="anio" class="form-control" min="2000" max="2100" value="{{ $anioSeleccionado }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary fw-semibold">
                            <i class="fa-solid fa-print me-1"></i> Abrir Lista
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
