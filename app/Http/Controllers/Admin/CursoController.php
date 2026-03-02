<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Curso;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ConfirmacionInscripcionCurso;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionMayorEdad;
use App\Mail\ConfirmacionMenorEdad;

use App\Models\AsistenciaDiaria;
use App\Exports\AsistenciaGrupoExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AsistenteCurso;

use App\Exports\AsistenciaExport;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
 

class CursoController extends Controller
{

    public function contenido()
    {
        return view('admin.cursos.contenido');
    }

    public function mostrarCursos()
    {
        // para la ruta perfil/cursos
        return view('perfil.cursos');
    }


    public function inscribirme($id)
{
    $user = auth()->user();
    $curso = Curso::findOrFail($id);

    DB::table('asistentes_cursos')->insert([
        'id_curso' => $curso->id,
        'nombre' => $user->datosGenerales->nombre,
        'edad' => $user->datosGenerales->edad ?? null,
        'telefono' => $user->datosGenerales->telefono ?? null,
        'correo' => $user->datosGenerales->email,
        'tutor_nombre' => $user->datosGenerales->tutor_nombre ?? null,
        'tutor_telefono' => $user->datosGenerales->tutor_telefono ?? null,
        'tutor_correo' => $user->datosGenerales->tutor_correo ?? null,
        'asistio' => 0,
        'constancia_emitida' => 0,
        'fecha_registro' => now(),
    ]);

    return back()->with('success', 'Te has inscrito correctamente al curso.');
}








public function index(Request $request)
{
    $query = Curso::withCount('asistentes'); // contar inscritos

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->search . '%')
              ->orWhere('ciudad', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('tipo')) {
        $query->where('tipo', $request->tipo);
    }

    if ($request->order_by === 'asc') {
        $query->orderBy('fecha', 'asc');
    } else {
        $query->orderBy('fecha', 'desc');
    }

    $cursos = $query->get();
    $tipos = Curso::select('tipo')->distinct()->pluck('tipo');

    return view('admin.cursos.index', compact('cursos', 'tipos'));
}


    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'hora' => 'required|string|max:10',
        'lugar' => 'required|string|max:255',
        'ciudad' => 'required|string|max:100',
        'tipo' => 'required|string|max:50',
        'facilitador' => 'nullable|string|max:255',
        'duracion' => 'nullable|integer',
        'descripcion' => 'nullable|string',
        'num_grupos' => 'required|integer|min:1',
        'flyer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'modalidad' => 'required|string',
        'horarios' => 'nullable|string|max:255',

    ]);

    // Unir fechas en una sola columna
    $fechaFormateada = $request->fecha_inicio . ' - ' . $request->fecha_fin;

    $flyerPath = null;

    if ($request->hasFile('flyer')) {
        $file = $request->file('flyer');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('flyers'), $filename);
        $flyerPath = 'flyers/' . $filename;
    }

    DB::table('cursos')->insert([
        'nombre' => $request->nombre,
        'fecha' => $fechaFormateada,
        'hora' => $request->hora,
        'lugar' => $request->lugar,
        'ciudad' => $request->ciudad,
        'tipo' => $request->tipo,
        'facilitador' => $request->facilitador,
        'duracion' => $request->duracion,
        'descripcion' => $request->descripcion,
        'num_grupos' => $request->num_grupos,
        'flyer' => $flyerPath,
        'modalidad' => $request->modalidad,
        'horarios' => $request->horarios,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.cursos.index')->with('success', 'Curso registrado correctamente.');
}

    public function mostrarFormularioInscripcion()
    {
        $cursos = DB::table('cursos')->orderBy('fecha', 'desc')->get();
        return view('inscripcion_publica', compact('cursos'));
    }

   
public function create()
{
    return view('admin.cursos.crear');
}

public function show($id)
{
    $curso = Curso::findOrFail($id);

    $asistentes = AsistenteCurso::where('id_curso', $id)
        ->with('diasAsistidos') // relación para asistencia por días
        ->get();

    return view('admin.cursos.show', compact('curso', 'asistentes'));
}

public function detalle($id)
{
    $curso = \App\Models\Curso::withCount('asistentes')->findOrFail($id);
    return view('admin.cursos.detalle', compact('curso'));


}

    public function marcarAsistencia($id)
{
    DB::table('asistentes_cursos')->where('id', $id)->update([
        'asistio' => true,
        'constancia_emitida' => true 
    ]);

    return back()->with('success', 'Asistencia marcada y constancia activada.');
}


    public function agregarAsistente(Request $request)
    {
        $request->validate([
            'edad' => 'required|integer|min:1',
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|required_if:edad,>=18|string|max:50',
            'correo' => 'nullable|required_if:edad,>=18|email|max:100',
            'nombre_tutor' => 'nullable|required_if:edad,<18|string|max:255',
            'contacto_tutor' => 'nullable|required_if:edad,<18|string|max:100',
            'grupo' => 'required|string|max:50',
        ]);

        DB::table('asistentes_cursos')->insert([
            'id_curso' => $request->id_curso,
            'edad' => $request->edad,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'tutor_nombre' => $request->nombre_tutor,
            'tutor_correo' => $request->contacto_tutor,
            'asistio' => false,
            'grupo' => $request->grupo,
        ]);

        return back()->with('success', 'Participante agregado correctamente.');
    }

   

    
    public function moverInscripcionesAAsistentes($idCurso)
{
    $inscripciones = DB::table('inscripciones_publicas')->where('id_curso', $idCurso)->get();

    foreach ($inscripciones as $inscripcion) {
        DB::table('asistentes_cursos')->insert([
            'id_curso' => $inscripcion->id_curso,
            'nombre' => $inscripcion->nombre_participante,
            'edad' => $inscripcion->edad,
            'telefono' => $inscripcion->telefono,
            'correo' => $inscripcion->correo,
            'tutor_nombre' => $inscripcion->nombre_tutor,
            'tutor_telefono' => $inscripcion->contacto_tutor,
            'asistio' => false,
            'constancia_emitida' => false,
            'fecha_registro' => now(),
        ]);
    }

    return back()->with('success', 'Participantes movidos a lista de asistentes.');
}
public function editarTemario($id)
{
    $curso = Curso::findOrFail($id);
    return view('admin.cursos.editar-temario', compact('curso'));
}



public function exportarTemarioPDF($id)
{
    $curso = Curso::findOrFail($id);

    $data = [
        'nombre' => $curso->nombre,
        'temario' => $curso->temario,
        'num_grupos' => $curso->num_grupos,
        'horarios' => $curso->horarios,
    ];

    $pdf = Pdf::loadView('admin.cursos.temario_pdf', $data);
    return $pdf->download('temario_curso_' . $curso->id . '.pdf');
}

public function generarTemarioPDF($id)
{
    $curso = Curso::findOrFail($id);
    $temario = json_decode($curso->temario, true);

    $pdf = Pdf::loadView('admin.cursos.pdf-temario', compact('curso', 'temario'));
    return $pdf->download("Temario_{$curso->nombre}.pdf");
}



public function verCursoPublico($id)
{
    $curso = Curso::findOrFail($id);
    return view('cursos.ver-publico', compact('curso'));
}

public function inscripcionCursoPublica($id)
{
    $curso = \App\Models\Curso::findOrFail($id);
    return view('cursos.inscripcion-curso', compact('curso'));
}

public function guardarInscripcionPublica(Request $request)
{
    $request->validate([
        'id_curso' => 'required|exists:cursos,id',
        'edad' => 'required|integer|min:1',
        'nombre_participante' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:50',
        'correo' => 'nullable|email|max:100',
        'nombre_tutor' => 'nullable|string|max:255',
        'contacto_tutor' => 'nullable|string|max:100',
    ]);

    DB::table('asistentes_cursos')->insert([
        'id_curso' => $request->id_curso,
        'nombre' => $request->nombre_participante,
        'edad' => $request->edad,
        'telefono' => $request->telefono,
        'correo' => $request->correo,
        'tutor_nombre' => $request->nombre_tutor,
        'tutor_telefono' => $request->contacto_tutor,
        'asistio' => false,
        'constancia_emitida' => false,
        'fecha_registro' => now(),
    ]);


    $curso = Curso::find($request->id_curso);

    if ($request->edad >= 18 && $request->correo) {
        Mail::to($request->correo)->send(new ConfirmacionMayorEdad($curso, $request->nombre_participante));
    } elseif ($request->edad < 18 && $request->contacto_tutor) {
        Mail::to($request->contacto_tutor)->send(new ConfirmacionMenorEdad($curso, $request->nombre_tutor, $request->nombre_participante));
    }

    return redirect()->back()->with('success', '¡Inscripción registrada correctamente!');
}

public function generarConstancia($id, $asistente_id)
{
    $curso = Curso::findOrFail($id);
    $asistente = DB::table('asistentes_cursos')->where('id', $asistente_id)->first();

    if (!$asistente) {
        abort(404, 'Asistente no encontrado.');
    }

    $data = [
        'nombre' => strtoupper($asistente->nombre),
        'descripcion' => $curso->descripcion ?? '',
        'plantilla' => public_path('assets/plantillas/cba5687eb36affdc0132a13ec37898ba_t.png'),
    ];

    $pdf = Pdf::loadView('admin.cursos.constancia_pdf', $data);
    return $pdf->download('Constancia_' . $asistente->nombre . '.pdf');
}



    // 1) Editar TODO el curso
    public function edit(Curso $curso)
    {
        return view('admin.cursos.edit', compact('curso'));
    }



   public function update(Request $req, Curso $curso)
{
    $curso->update($req->all());
    return redirect()->route('admin.cursos.detalle', $curso->id)
                     ->with('success','Curso actualizado.');
}


    // 2) Completar campos faltantes
    public function complete(Curso $curso)
    {
        // detecta campos null o vacíos
        $faltantes = collect($curso->toArray())
            ->filter(function($v,$k){ return is_null($v) || $v === ''; })
            ->keys();
        return view('admin.cursos.complete', compact('curso','faltantes'));
    }

    // 3) Editar un solo campo
    public function editField(Curso $curso, $field)
    {
        // valida que $field exista en fillable
        if (! in_array($field, (new Curso)->getFillable())) {
            abort(404);
        }
        return view('admin.cursos.edit-field', compact('curso','field'));
    }

    public function updateField(Request $req, Curso $curso, $field)
{
    // === Archivos ===
    if (in_array($field, ['temario', 'flyer'])) {
        if ($field === 'temario') {
            $req->validate([
                'value' => 'required|file|mimes:pdf|max:5120'
            ]);
        } else {
            $req->validate([
                'value' => 'required|image|mimes:jpg,jpeg,png|max:2048'
            ]);
        }

        if (!$req->hasFile('value') || !$req->file('value')->isValid()) {
            return back()->withErrors(['value' => 'Por favor selecciona un archivo válido.']);
        }

        $file      = $req->file('value');
        $timestamp = time();
        $ext       = $file->extension();
        $fileName  = "{$timestamp}_{$field}.{$ext}";

        if ($field === 'temario') {
            $file->move(public_path('plantillas'), $fileName);
            $curso->update(['temario' => "plantillas/{$fileName}"]);
        } else {
            $file->move(public_path('flyers'), $fileName);
            $curso->update(['flyer' => "{$fileName}"]);
        }
    }

    // === Fecha con inicio y fin ===
    elseif ($field === 'fecha') {
        $req->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $fecha = $req->input('fecha_inicio') . ' - ' . $req->input('fecha_fin');
        $curso->update(['fecha' => $fecha]);
    }

    // === Campo num_grupos con validación especial ===
    elseif ($field === 'num_grupos') {
        $req->validate([
            'value' => 'required|integer|min:1'
        ]);
        $curso->update(['num_grupos' => $req->input('value')]);
    }

    // === Otros campos normales (texto, select, etc.) ===
    else {
        $req->validate([
            'value' => 'required'
        ]);
        $curso->update([$field => $req->input('value')]);
    }

    return redirect()
         ->route('admin.cursos.detalle', $curso->id)
        ->with('success', "Campo “{$field}” actualizado correctamente.");
}






    public function guardarTemario(Request $req, Curso $curso)
    {
        $curso->update($req->only('temario','num_grupos','horarios'));
        return back()->with('success','Temario guardado.');
    }


  public function editAsistente($id)
{
    // Recupera el registro de la BD
    $asistente = DB::table('asistentes_cursos')->where('id', $id)->first();

    if (! $asistente) {
        abort(404, 'Participante no encontrado.');
    }

    // Guarda el id del curso en sesión para volver luego
    session(['last_curso_id' => $asistente->id_curso]);

    // Pasa la variable $asistente (no $asist) a la vista
    return view('admin.cursos.edit-asistente', compact('asistente'));
}


/**
 * Procesar la actualización del asistente.
 */
public function updateAsistente(Request $req, $id)
{
    $req->validate([
        'nombre'         => 'required|string|max:255',
        'edad'           => 'required|integer|min:1',
        'telefono'       => 'nullable|string|max:50',
        'correo'         => 'nullable|email|max:100',
        'nombre_tutor'   => 'nullable|string|max:255',
        'contacto_tutor' => 'nullable|string|max:100',
        'grupo'          => 'required|string|max:50',
    ]);

    DB::table('asistentes_cursos')
        ->where('id', $id)
        ->update([
            'nombre'         => $req->nombre,
            'edad'           => $req->edad,
            'telefono'       => $req->telefono,
            'correo'         => $req->correo,
            'tutor_nombre'   => $req->nombre_tutor,
            'tutor_telefono' => $req->contacto_tutor,
            'grupo'          => $req->grupo,
            'asistio'        => $req->has('asistio') ? 1 : 0,
        ]);

    return redirect()
        ->route('admin.cursos.show', $req->session()->get('last_curso_id'))
        ->with('success', 'Datos del participante actualizados.');
}










public function exportarAsistencia($curso_id, $grupo)
{
    $curso = Curso::findOrFail($curso_id);
    return Excel::download(new AsistenciaGrupoExport($curso, $grupo), "asistencia_grupo{$grupo}.xlsx");
}
public function diasAsistidos()
{
    return $this->hasMany(\App\Models\AsistenciaDiaria::class, 'id_asistente');
}

public function guardarAsistenciaDias(Request $request)
{
    if (!$request->has('asistencia')) {
        return back()->with('error', 'No se seleccionó ninguna casilla de asistencia.');
    }

    foreach ($request->asistencia as $id_asistente => $fechas) {
        foreach ($fechas as $fecha => $valor) {
            \App\Models\AsistenciaDiaria::updateOrCreate(
                ['id_asistente' => $id_asistente, 'fecha' => $fecha],
                ['asistio' => true]
            );
        }
    }

    return back()->with('success', 'Asistencia por día guardada correctamente.');
}




public function exportarAsistenciaExcel($idCurso, $grupo)
{
    $curso = Curso::findOrFail($idCurso);
    return Excel::download(new AsistenciaGrupoExport($curso, $grupo), 'asistencia_curso_grupo_'.$grupo.'.xlsx');
}

public function exportarAsistenciaPDF($id, $grupo)
{
    $curso = \App\Models\Curso::findOrFail($id);

    $periodo = [];
    if (!empty($curso->fecha) && str_contains($curso->fecha, ' - ')) {
        [$inicio, $fin] = explode(' - ', $curso->fecha);
        try {
            $periodo = CarbonPeriod::create(
                Carbon::createFromFormat('Y-m-d', trim($inicio)),
                Carbon::createFromFormat('Y-m-d', trim($fin))
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar las fechas');
        }
    }

    $asistentes = AsistenteCurso::where('id_curso', $curso->id)
        ->where('grupo', $grupo)
        ->with('diasAsistidos')
        ->get();

    $pdf = Pdf::loadView('admin.asistencia.lista_pdf', [
        'curso' => $curso,
        'asistentes' => $asistentes,
        'periodo' => $periodo,
        'grupo' => $grupo
    ]);

    return $pdf->download('lista_asistencia_grupo'.$grupo.'.pdf');
}



public function updateDetalle(Request $request, $id)
{
    $curso = Curso::findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|max:255',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'hora' => 'required|string|max:10',
        'lugar' => 'required|string|max:255',
        'ciudad' => 'required|string|max:100',
        'tipo' => 'required|string|max:50',
        'facilitador' => 'nullable|string|max:255',
        'duracion' => 'nullable|integer',
        'descripcion' => 'nullable|string',
        'num_grupos' => 'required|integer|min:1',
        'flyer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'modalidad' => 'required|string|in:Presencial,En línea',
        'horarios' => 'nullable|string|max:255',
    ]);

    $curso->update($request->all());

    return redirect()->route('admin.cursos.detalle', ['id' => $curso->id])
                 ->with('success', 'Curso actualizado correctamente');

}










public function actualizarDetalles($id)
{
    $curso = Curso::findOrFail($id);
    return view('admin.cursos.actualizar-detalles', compact('curso'));
}

public function guardarActualizacionDetalles(Request $request, $id)
{
    $curso = Curso::findOrFail($id);

    // Validación
    $request->validate([
        'nombre' => 'required|string|max:255',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'hora' => 'required|string|max:10',
        'lugar' => 'required|string|max:255',
        'ciudad' => 'required|string|max:100',
        'tipo' => 'required|string|max:50',
        'facilitador' => 'nullable|string|max:255',
        'duracion' => 'nullable|integer',
        'descripcion' => 'nullable|string',
        'num_grupos' => 'required|integer|min:1',
        'modalidad' => 'required|string|in:Presencial,En línea',
        'estado' => 'required|string|in:pendiente,aceptado',
        'horarios' => 'nullable|string|max:255',
        'flyer' => 'nullable|image|max:2048',       // 2MB
        'temario' => 'nullable|mimes:pdf|max:5120', // 5MB
    ]);

    // Manejo de archivos para public/flyers y public/temarios
    if ($request->hasFile('flyer')) {
        $flyerFile = $request->file('flyer');
        $flyerName = time() . '_' . $flyerFile->getClientOriginalName();
        $flyerFile->move(public_path('flyers'), $flyerName);
        $flyerPath = 'flyers/' . $flyerName;
    } else {
        $flyerPath = $curso->flyer;
    }

    if ($request->hasFile('temario')) {
        $temarioFile = $request->file('temario');
        $temarioName = time() . '_' . $temarioFile->getClientOriginalName();
        $temarioFile->move(public_path('temarios'), $temarioName);
        $temarioPath = 'temarios/' . $temarioName;
    } else {
        $temarioPath = $curso->temario;
    }

    // Concatenar fechas
    $fecha = $request->fecha_inicio . ' - ' . $request->fecha_fin;

    // Actualizar curso
    $curso->update([
        'nombre' => $request->nombre,
        'fecha' => $fecha,
        'hora' => $request->hora,
        'lugar' => $request->lugar,
        'ciudad' => $request->ciudad,
        'tipo' => $request->tipo,
        'facilitador' => $request->facilitador,
        'duracion' => $request->duracion,
        'descripcion' => $request->descripcion,
        'num_grupos' => $request->num_grupos,
        'modalidad' => $request->modalidad,
        'estado' => $request->estado,
        'horarios' => $request->horarios,
        'flyer' => $flyerPath,
        'temario' => $temarioPath,
    ]);

    return redirect()->route('admin.cursos.actualizardetalles', $curso->id)
                     ->with('success', 'Curso actualizado correctamente.');
}


}