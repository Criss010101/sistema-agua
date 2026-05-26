<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Historial de Consumo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f6fa; }
        .profile-card { background: white; border-radius: 16px; padding: 24px; border: 1px solid #e2e8f0; margin-bottom: 24px; }
        .table-card { background: white; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 900px;">
        <div class="mb-4"><a href="{{ route('home') }}" class="text-decoration-none text-secondary small fw-semibold"><i class="fa-solid fa-arrow-left me-1"></i> Volver a la búsqueda</a></div>

        <!-- Ficha del Socio -->
        <div class="profile-card d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <div>
                <span class="badge bg-primary mb-2" style="background-color: #6366f1 !important;">Socio Activo</span>
                <h3 class="fw-bold text-dark m-0">{{ $usuario->nombre }}</h3>
                <p class="text-muted m-0 mt-1">📍 Comunidad: <strong>{{ $usuario->comunidad->nombre ?? 'Sin especificar' }}</strong> | Código: #{{ $usuario->codigo_socio }}</p>
            </div>
            <div class="text-sm-end">
                <span class="text-muted d-block small">Medidor Asociado</span>
                <span class="badge px-3 py-2 fs-6 mt-1" style="background-color: #e0f2fe; color: #0369a1; font-family: monospace;">{{ $usuario->codigo_medidor }}</span>
            </div>
        </div>

        <!-- Tabla de Consumos -->
        <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-clock-rotate-left me-2 text-muted"></i>Historial de Mediciones</h5>
        <div class="card table-card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="p-3 text-muted small fw-bold">Fecha Registro</th>
                            <th class="text-muted small fw-bold">Lectura Anterior</th>
                            <th class="text-muted small fw-bold">Lectura Actual</th>
                            <th class="text-muted small fw-bold">Consumo Total</th>
                            <th class="text-muted small fw-bold">Monto a Pagar</th>
                            <th class="text-muted small fw-bold">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historial as $item)
                            <tr>
                                <td class="p-3 fw-medium text-secondary">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-muted">{{ $item->lectura_anterior }} m³</td>
                                <td class="text-dark fw-semibold">{{ $item->lectura_actual }} m³</td>
                                <td><span class="badge px-2.5 py-1.5 bg-success" style="background-color: #dcfce7 !important; color: #16a34a !important; font-weight: 700;">+{{ $item->consumo }} m³</span></td>
                                <td class="text-dark fw-semibold">{{ $item->total_pagar }} Bs</td>
                                <td>
                                    @if($item->estado === 'pagado')
                                        <span class="badge px-2.5 py-1.5" style="background-color: #dcfce7 !important; color: #16a34a !important; font-weight: 700;">✓ Pagado</span>
                                    @else
                                        <span class="badge px-2.5 py-1.5" style="background-color: #fee2e2 !important; color: #dc2626 !important; font-weight: 700;">⏳ Pendiente</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-5 text-muted">No se registran consumos procesados para este medidor todavía.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>