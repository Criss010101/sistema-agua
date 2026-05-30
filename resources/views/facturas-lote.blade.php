<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletas en Lote - C.A.P.</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @page { size: letter portrait; margin: 0.12in; }

        .factura-contenedor {
            width: 8.25in;
            max-width: 100%;
            padding: 0.22in !important;
            font-size: 10px;
            line-height: 1.15;
            box-sizing: border-box;
        }
        .factura-contenedor .text-center.mb-4 { margin-bottom: 0.08in !important; }
        .factura-contenedor h1 { font-size: 12px !important; line-height: 1.15; }
        .factura-contenedor h2 { font-size: 11px !important; padding: 3px 0 !important; margin-top: 0.06in !important; }
        .factura-contenedor p { font-size: 9px !important; }
        .factura-contenedor table { font-size: 10px !important; margin-bottom: 0.08in !important; }
        .factura-contenedor td { padding: 2px 4px !important; }
        .factura-contenedor .grid {
            display: grid !important;
            grid-template-columns: 2fr 1fr !important;
            gap: 0.07in !important;
            margin-bottom: 0.08in !important;
        }
        .factura-contenedor .md\:col-span-8,
        .factura-contenedor .md\:col-span-4 {
            grid-column: auto !important;
        }
        .factura-contenedor h3 { font-size: 9px !important; padding: 2px !important; }
        .factura-contenedor .text-xl { font-size: 16px !important; }
        .factura-contenedor .bg-yellow-300, .factura-contenedor .bg-green-50 { padding: 3px !important; font-size: 8.5px !important; line-height: 1.15 !important; }

        @media print {
            .no-imprimir { display: none !important; }
            body { background-color: white; padding: 0; font-size: 10px; }
            .factura-contenedor {
                box-shadow: none !important;
                border: 2px solid #000;
                width: 8.25in;
                height: 5.25in;
                margin: 0 auto 0.1in auto !important;
                overflow: hidden;
                break-inside: avoid;
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
        body { font-family: 'Courier New', Courier, monospace; }
    </style>
</head>
<body class="bg-gray-300 p-4">
    @php
        $mesesLote = [1=>'ENERO', 2=>'FEBRERO', 3=>'MARZO', 4=>'ABRIL', 5=>'MAYO', 6=>'JUNIO', 7=>'JULIO', 8=>'AGOSTO', 9=>'SEPTIEMBRE', 10=>'OCTUBRE', 11=>'NOVIEMBRE', 12=>'DICIEMBRE'];
        $periodoLote = ($mesesLote[$mesSeleccionado] ?? '') . ' ' . $anioSeleccionado;
    @endphp

    <div class="no-imprimir w-full flex justify-between items-center mb-4 gap-2">
        <a href="{{ route('lecturas.index') }}" class="bg-gray-700 text-white px-4 py-2 rounded text-sm hover:bg-gray-800">← Volver</a>
        <div class="bg-white border border-gray-400 px-4 py-2 rounded text-sm font-bold text-gray-800">
            Periodo: {{ $periodoLote }} - {{ $lecturas->count() }} boleta(s)
        </div>
        <button onclick="window.print()" class="bg-emerald-600 text-white px-6 py-2 rounded font-bold text-sm hover:bg-emerald-700 cursor-pointer" {{ $lecturas->isEmpty() ? 'disabled' : '' }}>🖨️ Generar Boletas</button>
    </div>

    @forelse($lecturas as $lectura)
        @php
            $lecturaAnterior = \App\Models\Lectura::where('usuario_id', $lectura->usuario_id)
                ->where('created_at', '<', $lectura->created_at)
                ->orderByDesc('created_at')
                ->first();
            
            $lecturaAnteriorValor = $lecturaAnterior ? $lecturaAnterior->lectura_actual : 0;
            
            $historico = \App\Models\Lectura::where('usuario_id', $lectura->usuario_id)
                ->where('id', '!=', $lectura->id)
                ->orderByDesc('created_at')
                ->limit(12)
                ->get();
            $mesesDeuda = $historico->where('estado', '!=', 'pagado')->count();

            $meses = [1=>'ENERO', 2=>'FEBRERO', 3=>'MARZO', 4=>'ABRIL', 5=>'MAYO', 6=>'JUNIO', 7=>'JULIO', 8=>'AGOSTO', 9=>'SEPTIEMBRE', 10=>'OCTUBRE', 11=>'NOVIEMBRE', 12=>'DICIEMBRE'];
        @endphp

        <div class="factura-contenedor bg-white w-full max-w-2xl p-6 border-2 border-gray-800 text-black shadow-2xl rounded-sm mx-auto mb-8">
            
            <div class="text-center mb-4">
                <h1 class="text-md font-black text-blue-900 tracking-tight">C.A.P. "18 de Mayo" com. Coronación, La Senda y Cachuela España</h1>
                <p class="text-[11px] font-bold text-cyan-800">Distrito II, Municipio San Javier, Provincia Ñuflo de Chávez, Dpto. Santa Cruz</p>
                <h2 class="text-sm font-black tracking-widest uppercase border-y-2 border-black py-1 mt-2 bg-gray-50">BOLETA DE PAGO POR CONSUMO DE AGUA POTABLE - C.A.P. 18 DE MAYO</h2>
            </div>

            <table class="w-full border-collapse border border-black text-[12px] mb-3">
                <tr class="bg-gray-100 text-center font-bold">
                    <td class="border border-black p-1">PERIODO</td>
                    <td class="border border-black p-1">FECHA DE EMISION</td>
                    <td class="border border-black p-1">FECHA DE VENCIMIENTO</td>
                    <td class="border border-black p-1">DIAS DE CONSUMO</td>
                    <td class="border border-black p-1">Nº DE MEDIDOR</td>
                </tr>
                <tr class="text-center font-mono font-bold">
                    <td class="border border-black p-1 bg-gray-50">
                        {{ $meses[$lectura->mes] ?? '' }} {{ $lectura->anio }}
                    </td>
                       <td class="border border-black p-1">{{ \Carbon\Carbon::create($lectura->anio, $lectura->mes, 28)->format('d/m/Y') }}</td>
                       <td class="border border-black p-1">{{ \Carbon\Carbon::create($lectura->anio, $lectura->mes, 28)->addMonthNoOverflow()->day(10)->format('d/m/Y') }}</td>
                       <td class="border border-black p-1">{{ $diasConsumo }} DIAS</td>
                       <td class="border border-black p-1">{{ $lectura->usuario->codigo_medidor }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="border border-black p-2 bg-white">
                        <span class="font-bold">NOMBRE:</span> <strong class="text-sm uppercase font-mono pl-2">{{ $lectura->usuario->nombre }}</strong>
                        <span class="font-bold pl-12">DIRECCION:</span> <span class="uppercase font-mono">COMUNIDAD {{ $lectura->usuario->comunidad->nombre }}</span>
                    </td>
                </tr>
                <tr class="bg-gray-50">
                    <td colspan="5" class="border border-black p-1 px-2 text-right">
                        <span class="font-bold text-xs">CÓDIGO DE BÚSQUEDA INTERNO (SOCIO):</span> 
                        <strong class="text-sm font-mono text-blue-950 bg-gray-200 px-2 py-0.5 rounded ml-1">
                            {{ strtoupper(substr($lectura->usuario->comunidad->nombre, 0, 3)) }}-{{ str_pad($lectura->usuario->codigo_socio, 4, '0', STR_PAD_LEFT) }}
                        </strong>
                    </td>
                </tr>
            </table>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 mb-4">
                
                <div class="md:col-span-8">
                    <h3 class="bg-gray-800 text-white font-bold text-xs p-1 text-center border border-black uppercase">Lecturacion C.A.P.</h3>
                    <table class="w-full border-collapse border border-black text-[12px]">
                        <thead class="bg-gray-100 font-bold text-center">
                            <tr>
                                <td class="border border-black p-1">DETALLE</td>
                                <td class="border border-black p-1 text-right">IMPORTE EN BS.</td>
                            </tr>
                        </thead>
                        <tbody class="font-mono">
                            <tr>
                                <td class="border border-black p-1">Imp. Por gasto de agua potable (min. 10 m3)</td>
                                <td class="border border-black p-1 text-right font-bold">23.00 Bs</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-1">CONSUMO ANTERIOR: <span class="float-right font-bold">{{ $lecturaAnteriorValor }} m3</span></td>
                                <td class="border border-black p-1 text-right text-gray-400">-</td>
                            </tr>
                            <tr>
                                <td class="border border-black p-1">CONSUMO ACTUAL: <span class="float-right font-bold">{{ $lectura->lectura_actual }} m3</span></td>
                                <td class="border border-black p-1 text-right text-gray-400">-</td>
                            </tr>
                            <tr class="bg-blue-50 font-bold">
                                <td class="border border-black p-1">CONSUMO TOTAL: <span class="float-right text-blue-900 font-black">{{ $lectura->consumo_mes }} m3</span></td>
                                <td class="border border-black p-1 text-right">23.00 Bs</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3 class="bg-gray-200 text-black font-bold text-[11px] p-0.5 text-center border-x border-b border-black uppercase mt-2">Tasa por Cubo Adicional</h3>
                    <table class="w-full border-collapse border border-black text-[11px] font-mono">
                        <tr class="bg-gray-50 font-bold text-center">
                            <td class="border border-black p-1">DETALLES</td>
                            <td class="border border-black p-1 text-right">IMPORTE EN BS.</td>
                        </tr>
                        <tr>
                            <td class="border border-black p-1">Cubos adicional (Bs. 3): <span class="float-right font-bold">{{ $lectura->consumo_mes > 10 ? ($lectura->consumo_mes - 10) : 0 }}</span></td>
                            <td class="border border-black p-1 text-right font-bold">
                                {{ $lectura->consumo_mes > 10 ? ($lectura->consumo_mes - 10) * 3 : 0 }} Bs
                            </td>
                        </tr>
                        @if(!empty($lectura->multas))
                            @foreach(explode(',', $lectura->multas) as $m)
                                @if(trim($m) != '')
                                    <tr class="bg-yellow-100" style="-webkit-print-color-adjust: exact;">
                                        <td class="border border-black p-1 uppercase font-bold">{{ trim($m) }}</td>
                                        <td class="border border-black p-1 text-right font-bold">50.00 Bs</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </table>
                </div>

                <div class="md:col-span-4 flex flex-col justify-between">
                    <div>
                        <h3 class="bg-gray-800 text-white font-bold text-xs p-1 text-center border border-black uppercase">Historico</h3>
                        <table class="w-full border-collapse border border-black text-[11px] text-center font-mono">
                            <thead class="bg-gray-100 font-bold">
                                <tr>
                                    <td class="border border-black p-1">PERIODO</td>
                                    <td class="border border-black p-1">M3</td>
                                    <td class="border border-black p-1">IMPOR. EN BS</td>
                                    <td class="border border-black p-1">ESTADO</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($historico as $h)
                                    <tr>
                                        <td class="border border-black p-1 font-sans">
                                            @php
                                                $mesesCortos = [1=>'ene', 2=>'feb', 3=>'mar', 4=>'abr', 5=>'may', 6=>'jun', 7=>'jul', 8=>'ago', 9=>'sep', 10=>'oct', 11=>'nov', 12=>'dic'];
                                            @endphp
                                            {{ $mesesCortos[$h->mes] ?? '' }}-{{ substr($h->anio, -2) }}
                                        </td>
                                        <td class="border border-black p-1">{{ $h->consumo_mes }}</td>
                                        <td class="border border-black p-1">{{ round($h->total_pagar) }}</td>
                                        <td class="border border-black p-1 text-[9px] font-bold {{ $h->estado === 'pagado' ? 'text-green-700' : 'text-red-600' }}">
                                            {{ $h->estado === 'pagado' ? 'PAGADO' : 'PENDIENTE' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border border-black p-4 text-gray-400 text-xs font-sans">Sin registros previos</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="border-2 border-black p-2 mt-2 bg-gray-50 text-center">
                        <span class="text-xs font-black block uppercase tracking-wider">Total a Cancelar</span>
                        <strong class="text-xl font-black font-mono text-blue-900">Bs. {{ number_format($lectura->total_pagar, 2) }}</strong>
                    </div>
                </div>
            </div>

            <div class="{{ $mesesDeuda >= 2 ? 'bg-yellow-300' : 'bg-green-50' }} border-2 border-black p-2 text-center font-sans font-bold text-[11px] leading-tight text-black">
                @if($mesesDeuda >= 2)
                    <span class="text-xs font-black uppercase text-red-700 block mb-0.5">En corte por falta de cancelacion del servicio basico de agua ( {{ $mesesDeuda }} meses).</span>
                @endif
                En {{ $lectura->usuario->comunidad->nombre }} se cobrara el servicio de agua el día {{ $fechaCobranza }}. A horas 14:00 PM. hasta las 18:00 PM. Lugar de cancelación oficina del comité de agua.
            </div>

        </div>
    @empty
        <div class="no-imprimir bg-white max-w-xl mx-auto mt-16 p-8 rounded border border-gray-300 text-center shadow">
            <h2 class="text-xl font-bold text-gray-800 mb-2">No hay boletas para {{ $periodoLote }}</h2>
            <p class="text-gray-600 text-sm">Vuelve y selecciona otro mes, año o comunidad.</p>
        </div>
    @endforelse

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
