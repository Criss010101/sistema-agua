<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Usuario;
use App\Models\Lectura;
use App\Models\Comunidad;

class LecturaController extends Controller
{
    // Muestra la página principal pública
    public function home() {
        return view('home');
    }

    public function dashboard(Request $request)
    {
        $mesSeleccionado = (int) $request->get('mes', now()->month);
        $anioSeleccionado = (int) $request->get('anio', now()->year);

        $comunidades = Comunidad::withCount('usuarios')->get();
        $lecturasMes = Lectura::with(['usuario.comunidad'])
            ->where('mes', $mesSeleccionado)
            ->where('anio', $anioSeleccionado)
            ->get();

        $pagadas = $lecturasMes->where('estado', 'pagado');
        $pendientes = $lecturasMes->where('estado', '!=', 'pagado');

        $stats = [
            'total_socios' => Usuario::count(),
            'total_comunidades' => $comunidades->count(),
            'boletas_mes' => $lecturasMes->count(),
            'consumo_mes' => $lecturasMes->sum('consumo_mes'),
            'pagadas' => $pagadas->count(),
            'pendientes' => $pendientes->count(),
            'total_recaudado' => $pagadas->sum('total_pagar'),
            'total_pendiente' => $pendientes->sum('total_pagar'),
        ];

        $resumenComunidades = $comunidades->map(function ($comunidad) use ($lecturasMes) {
            $lecturasComunidad = $lecturasMes->filter(fn ($lectura) => $lectura->usuario?->comunidad_id === $comunidad->id);
            $pagadas = $lecturasComunidad->where('estado', 'pagado');
            $pendientes = $lecturasComunidad->where('estado', '!=', 'pagado');

            return [
                'id' => $comunidad->id,
                'nombre' => $comunidad->nombre,
                'socios' => $comunidad->usuarios_count,
                'boletas' => $lecturasComunidad->count(),
                'consumo' => $lecturasComunidad->sum('consumo_mes'),
                'pagadas' => $pagadas->count(),
                'pendientes' => $pendientes->count(),
                'recaudado' => $pagadas->sum('total_pagar'),
                'deuda' => $pendientes->sum('total_pagar'),
            ];
        });

        $ultimasBoletas = Lectura::with(['usuario.comunidad'])
            ->latest()
            ->limit(8)
            ->get();

        $pendientesDetalle = $lecturasMes
            ->where('estado', '!=', 'pagado')
            ->sortByDesc('total_pagar')
            ->take(10);

        return view('dashboard', compact(
            'mesSeleccionado',
            'anioSeleccionado',
            'stats',
            'resumenComunidades',
            'ultimasBoletas',
            'pendientesDetalle',
            'comunidades'
        ));
    }

    // Busca el historial de un socio por su número de medidor
    public function consultarMedidor(Request $request) {
    $codigo_buscado = $request->get('codigo_medidor');
    
    // Usamos 'like' para buscar coincidencias parciales
    $usuario = \App\Models\Usuario::with('comunidad')
        ->where('codigo_medidor', 'LIKE', '%' . $codigo_buscado . '%')
        ->first();

    if (!$usuario) {
        return redirect()->route('home')->with('error', 'No se encontró ningún socio. Verifica si el código es correcto.');
    }

    $historial = \App\Models\Lectura::where('usuario_id', $usuario->id)->latest()->get();

    return view('historial', compact('usuario', 'historial'));
}

    // Muestra el panel de administración
    public function index(Request $request) {
        $comunidadSeleccionada = $request->get('comunidad_id');
        $comunidades = Comunidad::all();
        
        $usuarios = Usuario::with('comunidad')
            ->when($comunidadSeleccionada, function ($query) use ($comunidadSeleccionada) {
                return $query->where('comunidad_id', $comunidadSeleccionada);
            })
            ->get();

        return view('lecturas.index', compact('usuarios', 'comunidades', 'comunidadSeleccionada'));
    }

    // Guarda una nueva lectura
    public function store(Request $request) {
        $data = $request->validate([
            'usuario_id' => 'required',
            'lectura_actual' => 'required|numeric',
            'mostrar_mensaje_corte' => 'nullable|boolean',
        ]);

        $anterior = Lectura::where('usuario_id', $data['usuario_id'])->latest()->first();
        $lectura_anterior = $anterior ? $anterior->lectura_actual : 0;
        $consumo_mes = max(0, $data['lectura_actual'] - $lectura_anterior);
        $total_pagar = $this->calcularTotalPagar($consumo_mes);

        Lectura::create([
            'usuario_id' => $data['usuario_id'],
            'mes' => now()->month,
            'anio' => now()->year,
            'lectura_actual' => $data['lectura_actual'],
            'consumo_mes' => $consumo_mes,
            'total_pagar' => $total_pagar,
            'mostrar_mensaje_corte' => $request->boolean('mostrar_mensaje_corte'),
        ]);

        return back()->with('success', 'Lectura registrada correctamente.');
    }

    // Guarda un nuevo socio
    public function storeUsuario(Request $request) {
        $data = $request->validate([
            'nombre' => 'required',
            'comunidad_id' => 'required',
            'codigo_socio' => [
                'required',
                Rule::unique('usuarios')->where(function ($query) use ($request) {
                    return $query->where('comunidad_id', $request->comunidad_id);
                }),
            ],
            'codigo_medidor' => 'required|unique:usuarios,codigo_medidor',
            'lectura_inicial' => 'required|numeric|min:0',
        ]);

        $lecturaInicial = (float) $data['lectura_inicial'];

        $usuario = Usuario::create([
            'nombre' => $data['nombre'],
            'comunidad_id' => $data['comunidad_id'],
            'codigo_socio' => $data['codigo_socio'],
            'codigo_medidor' => $data['codigo_medidor'],
            'lectura_inicial' => $lecturaInicial,
        ]);

        $consumo_mes = max(0, $lecturaInicial);
        $total_pagar = $this->calcularTotalPagar($consumo_mes);

        Lectura::create([
            'usuario_id' => $usuario->id,
            'mes' => now()->month,
            'anio' => now()->year,
            'lectura_actual' => $lecturaInicial,
            'consumo_mes' => $consumo_mes,
            'total_pagar' => $total_pagar,
        ]);

        return back()->with('success', 'Socio registrado con su lectura inicial.');
    }

    protected function calcularTotalPagar(int $consumo_mes): float
    {
        $base = 23.00;

        if ($consumo_mes <= 10) {
            return $base;
        }

        return $base + ($consumo_mes - 10) * 3;
    }

    public function printFactura($lecturaId)
    {
        $lectura = Lectura::findOrFail($lecturaId);
        $lecturaAnterior = Lectura::where('usuario_id', $lectura->usuario_id)
            ->where('created_at', '<', $lectura->created_at)
            ->orderByDesc('created_at')
            ->first();
        
        $lecturaAnteriorValor = $lecturaAnterior ? $lecturaAnterior->lectura_actual : 0;
        $historico = Lectura::where('usuario_id', $lectura->usuario_id)
            ->where('id', '!=', $lectura->id)
            ->orderByDesc('created_at')
            ->limit(12)
            ->get();

        $fechaCobranza = request()->get('fecha_cobranza', now()->addDays(15)->format('d/m/Y'));
        $mensajeCorte = $lectura->mostrar_mensaje_corte
            ? request()->get('mensaje_corte', 'En corte por falta de cancelacion del servicio basico de agua ( 2 meses).')
            : null;

        return view('factura', compact('lectura', 'lecturaAnteriorValor', 'historico', 'fechaCobranza', 'mensajeCorte'));
    }

    public function generarFacturasLote(Request $request)
    {
        $data = $request->validate([
            'comunidad_id' => 'required|exists:comunidades,id',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:2100',
            'fecha_cobranza' => 'required|string',
        ]);

        $lecturas = Lectura::whereHas('usuario', function ($query) use ($data) {
            $query->where('comunidad_id', $data['comunidad_id']);
        })
            ->where('mes', $data['mes'])
            ->where('anio', $data['anio'])
            ->with(['usuario.comunidad'])
            ->orderBy('usuario_id')
            ->get();

        $mensajeCorte = 'En corte por falta de cancelacion del servicio basico de agua ( 2 meses).';

        return view('facturas-lote', [
            'lecturas' => $lecturas,
            'fechaCobranza' => $data['fecha_cobranza'],
            'mensajeCorte' => $mensajeCorte,
            'mesSeleccionado' => $data['mes'],
            'anioSeleccionado' => $data['anio'],
        ]);
    }

    public function pagosIndex(Request $request)
    {
        $comunidades = Comunidad::all();
        $comunidadSeleccionada = $request->get('comunidad_id', $comunidades->first()?->id);
        $mesSeleccionado = (int) $request->get('mes', now()->month);
        $anioSeleccionado = (int) $request->get('anio', now()->year);

        $lecturas = collect();

        if ($comunidadSeleccionada) {
            $lecturas = Lectura::with(['usuario.comunidad'])
                ->whereHas('usuario', function ($query) use ($comunidadSeleccionada) {
                    $query->where('comunidad_id', $comunidadSeleccionada);
                })
                ->where('mes', $mesSeleccionado)
                ->where('anio', $anioSeleccionado)
                ->join('usuarios', 'lecturas.usuario_id', '=', 'usuarios.id')
                ->orderBy('usuarios.codigo_socio')
                ->select('lecturas.*')
                ->get();
        }

        return view('pagos.index', compact(
            'comunidades',
            'comunidadSeleccionada',
            'mesSeleccionado',
            'anioSeleccionado',
            'lecturas'
        ));
    }

    public function actualizarPagos(Request $request)
    {
        $data = $request->validate([
            'comunidad_id' => 'required|exists:comunidades,id',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:2100',
            'pagados' => 'nullable|array',
            'pagados.*' => 'integer|exists:lecturas,id',
        ]);

        $lecturaIds = Lectura::whereHas('usuario', function ($query) use ($data) {
            $query->where('comunidad_id', $data['comunidad_id']);
        })
            ->where('mes', $data['mes'])
            ->where('anio', $data['anio'])
            ->pluck('id');

        $pagados = collect($data['pagados'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->intersect($lecturaIds);

        Lectura::whereIn('id', $lecturaIds)->update(['estado' => 'pendiente']);

        if ($pagados->isNotEmpty()) {
            Lectura::whereIn('id', $pagados)->update(['estado' => 'pagado']);
        }

        return redirect()
            ->route('pagos.index', [
                'comunidad_id' => $data['comunidad_id'],
                'mes' => $data['mes'],
                'anio' => $data['anio'],
            ])
            ->with('success', 'Pagos actualizados correctamente.');
    }

    public function reporteComunidad(Request $request)
    {
        $data = $request->validate([
            'comunidad_id' => 'required|exists:comunidades,id',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2000|max:2100',
        ]);

        $comunidad = Comunidad::findOrFail($data['comunidad_id']);
        $lecturas = Lectura::with(['usuario.comunidad'])
            ->whereHas('usuario', function ($query) use ($data) {
                $query->where('comunidad_id', $data['comunidad_id']);
            })
            ->where('mes', $data['mes'])
            ->where('anio', $data['anio'])
            ->join('usuarios', 'lecturas.usuario_id', '=', 'usuarios.id')
            ->orderBy('usuarios.codigo_socio')
            ->select('lecturas.*')
            ->get()
            ->map(function ($lectura) {
                $anterior = Lectura::where('usuario_id', $lectura->usuario_id)
                    ->where('created_at', '<', $lectura->created_at)
                    ->orderByDesc('created_at')
                    ->first();

                $lectura->lectura_anterior_reporte = $anterior ? $anterior->lectura_actual : 0;

                return $lectura;
            });

        return view('reportes.comunidad', [
            'comunidad' => $comunidad,
            'lecturas' => $lecturas,
            'mesSeleccionado' => $data['mes'],
            'anioSeleccionado' => $data['anio'],
        ]);
    }
}
