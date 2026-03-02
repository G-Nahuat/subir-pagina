<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use App\Models\ProductImage;
use App\Models\Emprendimiento;
use App\Models\EmprendimientoLogo;  
use App\Models\DatosGenerales;
use App\Models\Curso;
use App\Models\AsistenteCurso;
use App\Models\Evento;
use Carbon\Carbon;



class PerfilController extends Controller
{

    public function perfil()
{
    $user = Auth::user();
    $datos = $user->datosGenerales;

    if (!$datos) {
        return back()->with('error', 'No se encontraron los datos generales del usuario.');
    }

      // Obtener fecha actual
    $hoy = Carbon::now();

    // Filtrar cursos disponibles

$cursos = Curso::where('estado', 'aceptado')->get()->filter(function ($curso) {
    // Separar fechas
    $fechas = explode(' - ', $curso->fecha);

    if (count($fechas) === 2) {
        $fecha_fin = Carbon::parse(trim($fechas[1]));
        return $fecha_fin->isFuture(); // true si no ha terminado
    }

    return false; // Si no tiene formato válido, lo descartamos
});


    $misCursos = \App\Models\AsistenteCurso::with('curso')
        ->where('correo', $datos->email)
        ->get();

     $eventos = Evento::where('estado', 'activo')
        ->whereDate('fecha', '>=', $hoy)
        ->get();

    $misEventos = \App\Models\Asistente::with('evento')
        ->where('email', $datos->email)
        ->get();

    $constancias = \App\Models\AsistenteCurso::with('curso')
        ->where('correo', $datos->email)
        ->where('constancia_emitida', 1)
        ->get();

    return view('perfil.index', compact('datos', 'cursos', 'misCursos','constancias','eventos', 'misEventos'));
}

    
    public function show()
    {
        $user            = Auth::user();
        $datos           = $user->datosGenerales;
        // Trae productos con sus imágenes
        $products        = $user->products()->with('images')->get();
        
        $emprendimientos = $user->emprendimientos()->get();

        return view('perfil.seccion', compact(
            'datos',
            'products',
            'emprendimientos'
        ));
    }

    /**
     * Procesa el formulario de nuevo producto.
     */
   public function seccionProducto(Request $request)
{
    $data = $request->validate([
        'name'              => 'required|string|max:255',
        'description'       => 'required|string',
        'price'             => 'required|numeric|min:0',
        'id_emprendimiento' => 'required|exists:emprendimientos,id_emprendimiento',
        'images'            => 'required|array|min:1',
        'images.*'          => 'image|max:2048',
    ]);

    $imagenes = [];

    // Procesar imágenes
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $nombre = \Str::random(20) . '.' . $img->getClientOriginalExtension();
            $img->storeAs('public/images/productos', $nombre);
            $imagenes[] = $nombre;
        }
    }

    // Crear producto con imágenes como JSON
    Auth::user()->products()->create([
        'id_emprendimiento' => $data['id_emprendimiento'],
        'nombreproducto'    => $data['name'],
        'descripcion'       => $data['description'],
        'precio'            => $data['price'],
        'fotosproduct'      => json_encode($imagenes),
        'estado'            => 'activo',
    ]);

    return back()->with('success', 'Producto registrado correctamente.');
}

    public function seccionEmprendimiento(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'logo'        => 'nullable|image|max:2048',
            'telefono'    => 'nullable|string|max:20',
            'redes'       => 'nullable|string|max:255',
            'ubicacion'   => 'nullable|string|max:255',
        ]);

        // Crea el emprendimiento
        $empr = Auth::user()->emprendimientos()->create([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'telefono'    => $data['telefono'] ?? null,
            'redes'       => $data['redes']    ?? null,
            'ubicacion'   => $data['ubicacion']?? null,
        ]);

        // Guarda el logo si viene
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('emprendimientos', 'public');
            $empr->update(['logo' => $path]);
        }

        return back()->with('success_emprend', 'Emprendimiento registrado. Recibirás respuesta en 1-5 días hábiles.');
    }
public function actualizarAvatar(Request $request)
{
    $request->validate([
        'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $user  = Auth::user();
    $datos = $user->datosGenerales;

    if (!$datos) {
        return response()->json(['error' => 'Datos no encontrados'], 404);
    }

    // Borra la anterior si existe
    if ($datos->avatar) {
        \Storage::disk('public')->delete($datos->avatar);
    }

    // Guarda nueva
    $path = $request->file('avatar')->store('avatars', 'public');
    $datos->avatar = $path;
    $datos->save();

    return response()->json(['success' => true]);
}

public function verPublico($id)
{
    $datos = DatosGenerales::where('id_users', $id)->firstOrFail();

    $emprendimientos = Emprendimiento::where('id_users', $id)
        ->with('productos') // asume que tienes relación 'productos' en tu modelo
        ->get();

    return view('perfil.publico', compact('datos', 'emprendimientos'));
}



}
