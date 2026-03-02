<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Solicitud;
use App\Models\Producto;
use App\Models\Evento;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function index(Request $request)
{
    // 👇 CAMBIO CLAVE: Usar 'from-global' y 'to-global'
    $from = $request->input('from-global');
    $to = $request->input('to-global');

    // Rango de fechas (últimos 6 meses si no hay filtro)
    $start = $from ? Carbon::parse($from)->startOfMonth() : now()->subMonths(5)->startOfMonth();
    $end = $to ? Carbon::parse($to)->startOfMonth() : now()->startOfMonth();

    // Conteos generales
    $userCount = User::count();
    $pendingCount = Solicitud::where('estatus', 'pendiente')->count();
    $productCount = Producto::count();
    $eventCount = Evento::count();
    $emprendimientoCount = Emprendimiento::count();
    $cursoCount = DB::table('cursos')->count();

    // Inicializar arrays para las gráficas
    $months = [];
    $newUsers = [];
    $newEvents = [];
    $newEmprendimientos = [];
    $newCursos = [];

    // Generar datos por mes
    $period = CarbonPeriod::create($start, '1 month', $end);
    foreach ($period as $date) {
        $label = $date->format('F Y');
        $months[] = $label;

        $startMonth = $date->copy()->startOfMonth();
        $endMonth = $date->copy()->endOfMonth();

        $newUsers[] = User::whereBetween('created_at', [$startMonth, $endMonth])->count();
        $newEvents[] = Evento::whereBetween('fecha', [$startMonth, $endMonth])->count();
        $newEmprendimientos[] = Emprendimiento::whereBetween('created_at', [$startMonth, $endMonth])->count();
        $newCursos[] = DB::table('cursos')->whereBetween('fecha', [$startMonth, $endMonth])->count();
    }

    return view('admin.dashboard', compact(
        'userCount',
        'pendingCount',
        'productCount',
        'eventCount',
        'emprendimientoCount',
        'cursoCount',
        'months',
        'newUsers',
        'newEvents',
        'newEmprendimientos',
        'newCursos',
        'from',
        'to'
    ));
}


    public function exportPdf(Request $request, string $type)
    {
    

        $from = $request->input('from') ?? $request->input('from-global');
$to = $request->input('to') ?? $request->input('to-global');



        $labels = [];
        $counts = [];

        // Si no hay filtro, usar últimos 6 meses
        if (!$from || !$to) {
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $labels[] = $date->format('M Y');
                $counts[] = $this->getCountByType($type, $date->year, $date->month);
            }
        } else {
            $start = Carbon::parse($from)->startOfMonth();
            $end = Carbon::parse($to)->startOfMonth();

            while ($start <= $end) {
                $labels[] = $start->format('M Y');
                $counts[] = $this->getCountByType($type, $start->year, $start->month);
                $start->addMonth();
            }
        }

        $pdf = Pdf::loadView('admin.pdf.frecuencia_profesional', [
            'type' => $type,
            'labels' => $labels,
            'counts' => $counts,
            'from' => $from,
            'to' => $to,
        ])->setPaper('a4', 'portrait');

        return $pdf->download("informe_frecuencia_{$type}.pdf");
    }

    private function getCountByType($type, $year, $month)
    {
        switch ($type) {
            case 'usuarios':
                return User::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            case 'eventos':
                return Evento::whereYear('fecha', $year)->whereMonth('fecha', $month)->count();
            case 'emprendimientos':
                return Emprendimiento::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            case 'cursos':
                return DB::table('cursos')->whereYear('fecha', $year)->whereMonth('fecha', $month)->count();
            default:
                return 0;
        }
    }


    public function getNotificaciones()
{
    // Notificaciones de registro temporal
    $registros = DB::table('registro_temporal')
        ->where('pendiente', 1)
        ->select('id', DB::raw("'registro_temporal' as tipo"), 'nombre as descripcion', 'created_at')
        ->get();

    // Notificaciones de emprendimientos
    $emprendimientos = DB::table('temp_emprendimientos')
        ->where('pendiente', 1)
        ->select('id', DB::raw("'temp_emprendimientos' as tipo"), 'nombre as descripcion', 'created_at')
        ->get();

    // Notificaciones de productos
    $productos = DB::table('temp_products')
        ->where('pendiente', 1)
        ->select('id', DB::raw("'temp_products' as tipo"), 'nombre as descripcion', 'created_at')
        ->get();

    // Unir todas
    $notificaciones = $registros
        ->merge($emprendimientos)
        ->merge($productos)
        ->sortByDesc('created_at');

    return response()->json($notificaciones);
}

}