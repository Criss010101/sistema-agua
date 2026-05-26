<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pagos - Sistema de Agua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f4f6fa;
            color: #0f172a;
            font-family: Arial, sans-serif;
        }
        .page-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px;
        }
        .toolbar,
        .payment-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }
        .payment-row {
            display: grid;
            grid-template-columns: 56px 1fr 130px 130px 120px;
            gap: 16px;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .payment-row:last-child {
            border-bottom: 0;
        }
        .pay-check {
            width: 28px;
            height: 28px;
            accent-color: #16a34a;
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 92px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.78rem;
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
        .medidor-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 3px 8px;
            border-radius: 7px;
            font-family: monospace;
            font-weight: 700;
        }
        @media (max-width: 850px) {
            .payment-row {
                grid-template-columns: 44px 1fr;
            }
            .payment-row > div:nth-child(n+3) {
                grid-column: 2;
            }
        }
    </style>
</head>
<body>
    @php
        $meses = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];
    @endphp

    <div class="page-wrap">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="fw-bold mb-1">Pagos</h2>
                <p class="text-secondary mb-0">Marca los socios que pagaron y guarda el estado del periodo.</p>
            </div>
            <a href="{{ route('lecturas.index', ['comunidad_id' => $comunidadSeleccionada]) }}" class="btn btn-dark fw-semibold">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pagos.index') }}" method="GET" class="toolbar p-3 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-secondary small">Comunidad</label>
                    <select name="comunidad_id" class="form-select" required>
                        @foreach($comunidades as $comunidad)
                            <option value="{{ $comunidad->id }}" {{ (int) $comunidadSeleccionada === $comunidad->id ? 'selected' : '' }}>
                                {{ $comunidad->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary small">Mes</label>
                    <select name="mes" class="form-select" required>
                        @foreach($meses as $numeroMes => $nombreMes)
                            <option value="{{ $numeroMes }}" {{ $mesSeleccionado === $numeroMes ? 'selected' : '' }}>{{ $nombreMes }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary small">Año</label>
                    <input type="number" name="anio" class="form-control" min="2000" max="2100" value="{{ $anioSeleccionado }}" required>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary fw-semibold" type="submit">
                        <i class="fa-solid fa-filter me-1"></i> Ver Lista
                    </button>
                </div>
            </div>
        </form>

        <form action="{{ route('pagos.actualizar') }}" method="POST" class="payment-card overflow-hidden">
            @csrf
            <input type="hidden" name="comunidad_id" value="{{ $comunidadSeleccionada }}">
            <input type="hidden" name="mes" value="{{ $mesSeleccionado }}">
            <input type="hidden" name="anio" value="{{ $anioSeleccionado }}">

            <div class="d-flex justify-content-between align-items-center p-3 border-bottom bg-light">
                <div class="fw-bold">
                    {{ $meses[$mesSeleccionado] ?? '' }} {{ $anioSeleccionado }}
                    <span class="text-secondary fw-normal">({{ $lecturas->count() }} boleta(s))</span>
                </div>
                <button type="button" class="btn btn-outline-success btn-sm fw-semibold" id="marcarTodos">
                    <i class="fa-solid fa-check-double me-1"></i> Marcar todos
                </button>
            </div>

            @forelse($lecturas as $lectura)
                <label class="payment-row">
                    <input type="checkbox" class="pay-check js-pay-check" name="pagados[]" value="{{ $lectura->id }}" {{ $lectura->estado === 'pagado' ? 'checked' : '' }}>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $lectura->usuario->nombre }}</h5>
                        <div class="text-secondary">
                            Socio: <strong class="text-dark">#{{ $lectura->usuario->codigo_socio }}</strong>
                            <span class="ms-2">Medidor:</span> <span class="medidor-badge">{{ $lectura->usuario->codigo_medidor }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-secondary d-block small fw-semibold">Consumo</span>
                        <strong>{{ $lectura->consumo_mes }} m³</strong>
                    </div>
                    <div>
                        <span class="text-secondary d-block small fw-semibold">Total</span>
                        <strong>Bs. {{ number_format($lectura->total_pagar, 2) }}</strong>
                    </div>
                    <div>
                        <span class="status-pill {{ $lectura->estado === 'pagado' ? 'status-paid' : 'status-pending' }}">
                            {{ $lectura->estado === 'pagado' ? 'Pagado' : 'Pendiente' }}
                        </span>
                    </div>
                </label>
            @empty
                <div class="text-center p-5">
                    <i class="fa-solid fa-file-circle-xmark text-secondary mb-3" style="font-size: 2.2rem;"></i>
                    <p class="text-secondary fw-semibold mb-0">No hay boletas para esta comunidad y periodo.</p>
                </div>
            @endforelse

            <div class="d-flex justify-content-end gap-2 p-3 border-top bg-light">
                <a href="{{ route('lecturas.index', ['comunidad_id' => $comunidadSeleccionada]) }}" class="btn btn-secondary fw-semibold">Cancelar</a>
                <button type="submit" class="btn btn-success fw-semibold" {{ $lecturas->isEmpty() ? 'disabled' : '' }}>
                    <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Pagos
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('marcarTodos')?.addEventListener('click', function () {
            const checks = document.querySelectorAll('.js-pay-check');
            const shouldCheck = Array.from(checks).some((check) => !check.checked);
            checks.forEach((check) => check.checked = shouldCheck);
            this.innerHTML = shouldCheck
                ? '<i class="fa-solid fa-xmark me-1"></i> Desmarcar todos'
                : '<i class="fa-solid fa-check-double me-1"></i> Marcar todos';
        });
    </script>
</body>
</html>
