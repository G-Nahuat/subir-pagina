<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Emprendimiento;
use App\Models\Municipio;
use App\Models\Producto;
use App\Models\DatosGenerales;
use App\Models\User;
use App\Models\Asistente;
use App\Models\Evento;
use App\Models\Curso;

class EmprendimientoController extends Controller
{
    /**
     * Catálogo unificado de emprendimientos y cursos con filtros y paginación.
     */
   public function catalogo(Request $request)
{
    $emprendimientosQuery = Emprendimiento::with('datosGenerales.municipio');
    $cursosQuery = Curso::query();

    // Filtro por palabra clave
    if ($request->filled('buscar')) {
        $buscar = $request->buscar;
        $emprendimientosQuery->where(function($q) use ($buscar) {
            $q->where('nombre', 'like', "%$buscar%")
              ->orWhere('descripcion', 'like', "%$buscar%");
        });
        $cursosQuery->where(function($q) use ($buscar) {
            $q->where('titulo', 'like', "%$buscar%")
              ->orWhere('descripcion', 'like', "%$buscar%");
        });
    }

    // Filtro por tipo (solo aplicar si está definido)
    if ($request->filled('tipo')) {
        $tipos = (array) $request->tipo;
        if (!in_array('emprendimiento', $tipos)) {
            $emprendimientosQuery->whereRaw('1 = 0'); // No mostrar ninguno
        }
        if (!in_array('curso', $tipos)) {
            $cursosQuery->whereRaw('1 = 0');
        }
    }

    // Filtro por municipio
    if ($request->filled('municipio')) {
        $emprendimientosQuery->whereHas('datosGenerales.municipio', function($q) use ($request) {
            $q->where('municipio', $request->municipio);
        });
    }

    // Filtro por modalidad de curso
    if ($request->filled('modalidad')) {
        $cursosQuery->whereIn('modalidad', (array)$request->modalidad);
    }

    // Filtro por estado de curso
    if ($request->filled('estado_curso')) {
        $cursosQuery->whereIn('estado', (array)$request->estado_curso);
    }

    // Ordenamientos
    if ($request->filled('orden_emprendimientos')) {
        $emprendimientosQuery->orderBy('nombre', $request->orden_emprendimientos);
    }
    if ($request->filled('orden_cursos')) {
        $cursosQuery->orderBy('titulo', $request->orden_cursos);
    }

    $emprendimientos = $emprendimientosQuery->paginate(6)->appends($request->except('page'));
    $cursos = $cursosQuery->paginate(6)->appends($request->except('page'));

    $municipios = Municipio::select('municipio')
                ->distinct()
                ->orderBy('municipio')
                ->pluck('municipio');

    return view('emprendimientos.catalogo', [
        'emprendimientos' => $emprendimientos,
        'cursos' => $cursos,
        'municipios' => $municipios,
        'filtros' => $request->all(), // para que la vista mantenga los valores seleccionados
    ]);
}

    // Resto de tus métodos existentes...
    public function verVendedor($id)
    {
        $emprendimientos = Emprendimiento::where('id_users', $id)->get();
        $productos = DB::table('productos')->where('id_users', $id)->get();

        return view('emprendimientos.vendedor', compact('emprendimientos', 'productos'));
    }

    public function mostrarVendedor($id)
    {
        $vendedor = User::where('id_users', $id)->firstOrFail();
        $emprendimientos = Emprendimiento::where('id_users', $id)->get();
        $productos = Producto::where('id_users', $id)->get();

        return view('emprendimientos.vendedor', compact('vendedor', 'emprendimientos', 'productos'));
    }

    public function perfilVendedor($id)
    {
        $emprendimientos = Emprendimiento::where('id_users', $id)->get();
        $productos = Producto::where('id_users', $id)->get();
        $vendedor = DatosGenerales::where('id_users', $id)->first();

        return view('emprendimientos.vendedor', compact('vendedor', 'emprendimientos', 'productos'));
    }

    public function showAsistenteForm()
    {
        return view('eventos.registro');
    }

    public function storeAsistente(Request $request)
    {
        $data = $request->validate([
            'curp'               => 'required|unique:asistentes,curp',
            'nombre_completo'    => 'required|string',
            'fecha_nacimiento'   => 'required|date',
            'sexo'               => 'required|string',
            'entidad_nacimiento' => 'required|string',
            'privacidad'         => 'accepted',
        ]);

        Asistente::create($data);

        return redirect()->route('eventos.create')
                         ->with('success', '¡Registrado correctamente!');
    }

    public function showCrearEvento()
    {
        return view('eventos.crear');
    }

    public function storeEvento(Request $request)
    {
        $validated = $request->validate([
            'descripcion'    => 'required|string',
            'lugar'          => 'required|string',
            'fecha'          => 'required|date',
            'horario'        => 'required|string',
            'id_programa'    => 'nullable|string',
            'delegacion'     => 'nullable|string',
            'tipo'           => 'nullable|string',
            'constancia'     => 'required|boolean',
            'reconocimiento' => 'required|boolean',
            'fotos.*'        => 'nullable|image|max:2048',
        ]);

        $evento = Evento::create($validated);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('eventos', 'public');
            }
        }

        return response()->json(['success' => true, 'evento' => $evento]);
    }

    public function mostrarFormularioRegistro()
    {
        $grados = DB::table('catalogo_gradoestudios')->orderBy('id')->get();
        return view('eventos.registro', compact('grados'));
    }

    public function perfil($id_emprendimiento)
{
    $emprendimientos = Emprendimiento::where('id_emprendimiento', $id_emprendimiento)->get(); // colección

    $productos = Producto::where('id_emprendimiento', $id_emprendimiento)
                         ->where('estado', 'activo')
                         ->get();

    $datos = DatosGenerales::where('id_users', $emprendimientos->first()->id_users)->first();

    return view('emprendimientos.perfil', compact('emprendimientos', 'productos', 'datos'));
}


    public function index()
    {
        $emprendimientos = Emprendimiento::all();
        return view('admin.emprendimiento.index', compact('emprendimientos'));
    }
}