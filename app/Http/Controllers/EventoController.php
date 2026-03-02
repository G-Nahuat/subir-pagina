<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistente;
use App\Models\Evento;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class EventoController extends Controller
{
   public function index(Request $request)
{
    $query = Evento::query();

    if ($request->filled('tipo')) {
        $query->where('tipo', $request->tipo);
    }

    if ($request->filled('search')) {
        $query->where('descripcion', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('order_by')) {
        $order = $request->order_by === 'asc' ? 'asc' : 'desc';
        $query->orderBy('fecha', $order);
    } else {
        $query->orderBy('fecha', 'desc');
    }

    $eventos = $query->get();

    // aunque NO uses el select, mándalo para evitar error
    $tipos = Evento::distinct()->pluck('tipo')->filter();  // filtra nulos

    return view('admin.eventos.index', compact('eventos', 'tipos'));
}


    public function create()
    {
        return view('admin.eventos.crear');
    }

    // Guardar un nuevo evento
    
    
        public function store(Request $request)
{
    try {
        $request->validate([
            'descripcion'   => 'required|string|max:255',
            'lugar'         => 'required|string|max:255',
            'fecha'         => 'required|date',
            'hora_inicio'   => 'required',
            'hora_fin'      => 'required',
            'delegacion'    => 'required|string|max:255',
            'tipo'          => 'required|string|max:255',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            'fotos'         => 'nullable|image|mimes:jpeg,png,jpg|'
        ]);

        $hora_inicio = $request->hora_inicio;
        $hora_fin = $request->hora_fin;
        $horario = date("g:i A", strtotime($hora_inicio)) . ' - ' . date("g:i A", strtotime($hora_fin));

        $nombreArchivo = null;
        if ($request->hasFile('fotos')) {
            $archivo = $request->file('fotos');
            $nombreArchivo = time() . '.' . $archivo->getClientOriginalExtension();
            $archivo->storeAs('public/eventos', $nombreArchivo);
        }

        Evento::create([
            'descripcion'     => $request->descripcion,
            'lugar'           => $request->lugar,
            'fecha'           => $request->fecha,
            'fotos'           => $nombreArchivo,
            'horario'         => $horario,
            'delegacion'      => $request->delegacion,
            'tipo'            => $request->tipo,
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
        ]);

        \Log::info("EVENTO CREADO OK");

        return redirect()->route('admin.dashboard')->with('success', '¡Evento registrado correctamente!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error("VALIDATION ERROR: ".json_encode($e->errors()));
        return back()->withErrors($e->errors());
    } catch (\Exception $e) {
        \Log::error("FALLO EVENTO: ".$e->getMessage());
        return back()->withErrors('Error: '.$e->getMessage());
    }
}


    // Mostrar formulario de inscripción de asistentes
    public function mostrarFormularioRegistro()
    {
        $grados = DB::table('catalogo_gradoestudios')->orderBy('id')->get();
        return view('eventos.registro', compact('grados'));
    }

    // Guardar un asistente
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

    // Mostrar eventos ordenados (próximos primero)
    public function lista()
    {
        $eventos = Evento::all()->sortBy(function ($evento) {
            $horas = explode('-', $evento->horario);
            $horaFin = isset($horas[1]) ? trim($horas[1]) : '11:59 PM';
            $finEvento = Carbon::parse($evento->fecha . ' ' . $horaFin);
            return $finEvento->lt(now()) ? now()->addYears(100) : $finEvento;
        })->values();

        return view('home', compact('eventos'));
    }

    // Mostrar detalle de un evento
    public function show($id)
    {
        $evento = Evento::findOrFail($id);
        return view('admin.eventos.show', compact('evento'));
    }

    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        return view('admin.eventos.edit', compact('evento'));
    }

 public function update(Request $request, $id)
{
    $evento = Evento::findOrFail($id);

    $request->validate([
        'descripcion'   => 'required|string|max:255',
        'lugar'         => 'required|string|max:255',
        'fecha'         => 'required|date',
        'hora_inicio'   => 'required',
        'hora_fin'      => 'required',
        'delegacion'    => 'nullable|string|max:255',
        'tipo'          => 'nullable|string|max:255',
        'latitude'      => 'nullable|numeric',
        'longitude'     => 'nullable|numeric',
        'fotos'         => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
    ]);

    $hora_inicio = $request->hora_inicio;
    $hora_fin = $request->hora_fin;

    $horario = date("g:i A", strtotime($hora_inicio)) . ' - ' . date("g:i A", strtotime($hora_fin));

    $evento->descripcion     = $request->descripcion;
    $evento->lugar           = $request->lugar;
    $evento->fecha           = $request->fecha;
    $evento->horario         = $horario;
    $evento->delegacion      = $request->delegacion;
    $evento->tipo            = $request->tipo;
    $evento->latitude        = $request->latitude;
    $evento->longitude       = $request->longitude;

    if ($request->hasFile('fotos')) {
        $archivo = $request->file('fotos');
        $nombreArchivo = time() . '.' . $archivo->getClientOriginalExtension();
        $archivo->storeAs('public/eventos', $nombreArchivo);
        $evento->fotos = $nombreArchivo;
    }

    $evento->save();

    return redirect()->route('admin.dashboard', $evento->id_evento)
                     ->with('success', 'Evento actualizado correctamente');
}

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);

        if ($evento->fotos && file_exists(public_path('images/eventos/' . $evento->fotos))) {
            unlink(public_path('images/eventos/' . $evento->fotos));
        }

        $evento->delete();

        return redirect()->route('admin.dashboard')->with('eliminado', 'Evento eliminado correctamente.');
    }

    // Notificaciones de próximos eventos
    public function eventosProximosNotificaciones()
    {
        $hoy = Carbon::today();
        $limite = Carbon::today()->addMonth();

        $eventosProximos = Evento::whereBetween('fecha', [$hoy, $limite])->orderBy('fecha')->get();

        return $eventosProximos;
    }

    // Detalle evento para vista pública
    public function detalleEvento($id)
    {
        $evento = Evento::findOrFail($id);
        return view('eventos.show', compact('evento'));
}
}