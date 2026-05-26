<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Consumo - {{ $comunidad->nombre }}</title>
    <style>
        @page {
            size: letter landscape;
            margin: 0.25in;
        }
        body {
            margin: 0;
            padding: 18px;
            background: #e5e7eb;
            color: #111827;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .toolbar {
            max-width: 10.5in;
            margin: 0 auto 12px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .btn {
            display: inline-block;
            padding: 9px 14px;
            border: 0;
            border-radius: 6px;
            background: #0f172a;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-print {
            background: #059669;
        }
        .sheet {
            max-width: 10.5in;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #111827;
            padding: 16px;
        }
        h1,
        h2,
        p {
            margin: 0;
            text-align: center;
        }
        h1 {
            font-size: 16px;
            letter-spacing: 0.3px;
        }
        h2 {
            margin-top: 4px;
            font-size: 13px;
            text-transform: uppercase;
        }
        .meta {
            margin: 12px 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        th,
        td {
            border: 1px solid #111827;
            padding: 5px 6px;
            vertical-align: middle;
        }
        th {
            background: #e5e7eb;
            text-transform: uppercase;
            font-size: 10px;
        }
        td.num,
        th.num {
            text-align: right;
        }
        td.center,
        th.center {
            text-align: center;
        }
        .estado {
            font-weight: 800;
            text-transform: uppercase;
        }
        .pagado {
            color: #15803d;
        }
        .pendiente {
            color: #b91c1c;
        }
        .totales {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            font-weight: 800;
        }
        .total-box {
            border: 1px solid #111827;
            padding: 8px;
            background: #f9fafb;
        }
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .sheet {
                max-width: none;
                border: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    @php
        $meses = [1=>'ENERO', 2=>'FEBRERO', 3=>'MARZO', 4=>'ABRIL', 5=>'MAYO', 6=>'JUNIO', 7=>'JULIO', 8=>'AGOSTO', 9=>'SEPTIEMBRE', 10=>'OCTUBRE', 11=>'NOVIEMBRE', 12=>'DICIEMBRE'];
        $totalConsumo = $lecturas->sum('consumo_mes');
        $totalCobrar = $lecturas->sum('total_pagar');
        $totalPagado = $lecturas->where('estado', 'pagado')->sum('total_pagar');
        $totalPendiente = $lecturas->where('estado', '!=', 'pagado')->sum('total_pagar');
    @endphp

    <div class="toolbar no-print">
        <a href="{{ route('dashboard') }}" class="btn">← Volver</a>
        <button type="button" onclick="window.print()" class="btn btn-print">Imprimir Lista</button>
    </div>

    <div class="sheet">
        <h1>C.A.P. "18 de Mayo"</h1>
        <h2>Lista de consumo y pagos por comunidad</h2>
        <p>Reporte tipo planilla para control interno</p>

        <div class="meta">
            <div>Comunidad: {{ strtoupper($comunidad->nombre) }}</div>
            <div>Periodo: {{ $meses[$mesSeleccionado] ?? '' }} {{ $anioSeleccionado }}</div>
            <div>Fecha: {{ now()->format('d/m/Y') }}</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="center">N°</th>
                    <th class="center">Socio</th>
                    <th>Nombre</th>
                    <th class="center">Medidor</th>
                    <th class="num">Consumo anterior</th>
                    <th class="num">Consumo actual</th>
                    <th class="num">Consumo mes</th>
                    <th class="num">Total Bs.</th>
                    <th class="center">Estado</th>
                    <th>Firma / Observación</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lecturas as $index => $lectura)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td class="center">{{ $lectura->usuario->codigo_socio }}</td>
                        <td>{{ strtoupper($lectura->usuario->nombre) }}</td>
                        <td class="center">{{ $lectura->usuario->codigo_medidor }}</td>
                        <td class="num">{{ $lectura->lectura_anterior_reporte }} m³</td>
                        <td class="num">{{ $lectura->lectura_actual }} m³</td>
                        <td class="num">{{ $lectura->consumo_mes }} m³</td>
                        <td class="num">{{ number_format($lectura->total_pagar, 2) }}</td>
                        <td class="center estado {{ $lectura->estado === 'pagado' ? 'pagado' : 'pendiente' }}">
                            {{ $lectura->estado === 'pagado' ? 'Pagado' : 'Pendiente' }}
                        </td>
                        <td></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="center">No hay lecturas para esta comunidad y periodo.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="totales">
            <div class="total-box">Socios: {{ $lecturas->count() }}</div>
            <div class="total-box">Consumo: {{ $totalConsumo }} m³</div>
            <div class="total-box">Pagado: Bs. {{ number_format($totalPagado, 2) }}</div>
            <div class="total-box">Pendiente: Bs. {{ number_format($totalPendiente, 2) }}</div>
        </div>
    </div>
</body>
</html>
