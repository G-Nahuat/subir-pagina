<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Evento;
use App\Models\Solicitud;
use App\Models\Producto;
use App\Models\TempProduct;
use App\Models\TempEmprendimiento;
use App\Models\Emprendimiento;
use Illuminate\Support\Facades\Storage;
use App\Models\Asistente;



class AdminController extends Controller
{
    public function indexUsuarios()
{
    $usuarios = User::whereHas('datosGenerales')->with('datosGenerales')->get();
    return view('admin.usuarios.index', compact('usuarios'));
}


    public function dashboard()
    {
        $userCount = User::where('tipo', 2)->count();
        $pendingCount = Solicitud::where('estatus', 'pendiente')->count();
        $productCount = Producto::count();

        return view('admin.dashboard', compact('userCount', 'pendingCount', 'productCount'));
    }

   public function cargarVista($seccion)
{
    switch($seccion) {
        case 'dashboard':
            $userCount    = User::count();
            $pendingCount = Solicitud::where('estatus','pendiente')->count();
            $productCount = Producto::count();
            $cursoCount   = \DB::table('cursos')->count();
            $eventCount   = Evento::count();
            $emprendimientoCount = Emprendimiento::count();

            $months = collect(range(0, 5))->map(function($i) {
                return now()->subMonths($i)->format('M');
            })->reverse()->values();

            $newUsers = $months->map(function($month) {
                return User::where('tipo', 2)->whereMonth('created_at', now()->parse($month)->month)->count();
            });

            $newEvents = $months->map(function($month) {
                return Evento::whereMonth('created_at', now()->parse($month)->month)->count();
            });

            $newEmprendimientos = $months->map(function($month) {
                return Emprendimiento::whereMonth('created_at', now()->parse($month)->month)->count();
            });

            $newCursos = $months->map(function($month) {
                return \DB::table('cursos')->whereMonth('created_at', now()->parse($month)->month)->count();
            });

            return view('admin.dashboard', compact(
                'userCount', 'pendingCount', 'productCount', 'cursoCount', 'eventCount', 'emprendimientoCount',
                'months', 'newUsers', 'newEvents', 'newEmprendimientos', 'newCursos'
            ));

        case 'usuarios':
            $users = User::where('tipo', 2)->with('datosGenerales')->paginate(10);
            return view('admin.usuarios.index', compact('users'));

        case 'eventos':
            $eventos = Evento::orderBy('fecha', 'desc')->get();
            return view('admin.eventos.index', compact('eventos'));

        case 'inscripciones-eventos':
            $inscripciones = Asistente::with('evento', 'usuario.datosGenerales')->get();
            return view('admin.eventos.inscripciones', compact('inscripciones'));

        case 'inscripciones':
            $solicitudes = Solicitud::with('usuario.datosGenerales')->paginate(10);
            return view('admin.inscripciones.index', compact('solicitudes'));

        case 'productos':
            $productos = Producto::with(['usuario', 'emprendimiento'])->get();
            return view('admin.productos.index', compact('productos'));

        case 'solicitudes-productos':
            $solicitudes = TempProduct::with('usuario.datosGenerales', 'emprendimiento')->get();
            return view('admin.productos.solicitudes', compact('solicitudes'));

        case 'emprendimientos':
            $emprendimientos = Emprendimiento::with('usuario.datosGenerales')->get();
            return view('admin.emprendimiento.index', compact('emprendimientos'));

        case 'solicitudes-emprendimientos':
            $solicitudes = TempEmprendimiento::with('usuario.datosGenerales')
                ->where('estado', 'pendiente')->get();
            return view('admin.emprendimiento.solicitudes', compact('solicitudes'));

        case 'cursos':
            $request = request();
            $query = \DB::table('cursos');

            if ($request->filled('search')) {
                $query->where('nombre', 'like', '%' . $request->search . '%')
                      ->orWhere('ciudad', 'like', '%' . $request->search . '%');
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
            $tipos = \DB::table('cursos')->select('tipo')->distinct()->pluck('tipo');

            return view('admin.cursos.index', compact('cursos', 'tipos'));


        default:
            return response()->view('errors.404', [], 404);
    }
}

    public function verUsuario($user)
    {
        $u = User::with('datosGenerales')->findOrFail($user);
        return view('admin.usuarios.show', compact('u'));
    }

    public function solicitudesProductos()
    {
        $solicitudes = TempProduct::with('usuario.datosGenerales', 'emprendimiento')->get();
        return view('admin.productos.solicitudes', compact('solicitudes'));
    }

    public function aprobarProducto($id)
    {
        $temp = TempProduct::findOrFail($id);

        $producto = new Producto();
        $producto->id_users = $temp->id_users;
        $producto->id_emprendimiento = $temp->id_emprendimiento;
        $producto->nombreproducto = $temp->nombreproducto;
        $producto->descripcion = $temp->descripcion;
        $producto->precio = $temp->precio;
        $producto->fotosproduct = $temp->fotosproduct;
        $producto->estado = 'activo';
        $producto->save();

        $temp->delete();

        return redirect()->back()->with('success', 'Producto aprobado y guardado correctamente.');
    }

    public function aceptarProducto($id)
    {
        $tempProduct = TempProduct::findOrFail($id);

        $fotos = is_array($tempProduct->fotosproduct)
            ? $tempProduct->fotosproduct
            : json_decode($tempProduct->fotosproduct, true);

        $nombreImagen = $fotos[0] ?? null;

        if ($nombreImagen) {
            $origen = "$nombreImagen";
            $destino = "images/productos/$nombreImagen";

            if (Storage::disk('public')->exists($origen)) {
                $movido = Storage::disk('public')->move($origen, $destino);

                if (!$movido) {
                    return back()->with('error', "No se pudo mover la imagen.");
                }
            } else {
                return back()->with('error', "La imagen no se encontró en $origen");
            }
        } else {
            return back()->with('error', 'No se encontró ninguna imagen en el producto temporal.');
        }

        Producto::create([
            'id_users'          => $tempProduct->id_users,
            'id_emprendimiento' => $tempProduct->id_emprendimiento,
            'nombreproducto'    => $tempProduct->nombreproducto,
            'descripcion'       => $tempProduct->descripcion,
            'precio'            => $tempProduct->precio,
            'fotosproduct'      => $nombreImagen,
            'estado'            => 'activo',
            'created_at'        => now(),
        ]);

        $tempProduct->delete();

        return back()->with('success', 'Producto aceptado y migrado correctamente.');
    }


   public function verEmprendimiento($id)
{
    $emprendimiento = Emprendimiento::with('usuario.datosGenerales')->findOrFail($id);
    return view('admin.emprendimiento.show', compact('emprendimiento'));

}

public function eliminarEmprendimiento($id)
{
    $emprendimiento = Emprendimiento::findOrFail($id);
    $emprendimiento->delete();

    return redirect()->back()->with('eliminado', true);
}

public function mostrarSolicitudes()
{
    $solicitudes = TempEmprendimiento::with('usuario.datosGenerales')->get();
    return view('admin.emprendimiento.solicitudes', compact('solicitudes'));
}

public function rechazarSolicitudEmprendimiento($id)
{
    $temp = TempEmprendimiento::findOrFail($id);

    // Eliminar imagen del disco si existe
    if ($temp->logo && \Storage::disk('public')->exists($temp->logo)) {
        \Storage::disk('public')->delete($temp->logo);
    }

    // Eliminar el registro
    $temp->delete();

    return redirect()->back()->with('success', 'Emprendimiento rechazado y eliminado');
}


public function verSolicitud($id)
{
    $solicitud = TempEmprendimiento::with('usuario.datosGenerales')->findOrFail($id);
    return view('admin.emprendimiento.show_solicitud', compact('solicitud'));


}


public function verInscripcionesEventos()
{
    $inscripciones = Asistente::with('evento', 'usuario.datosGenerales')->get();

    return view('admin.eventos.inscripciones', compact('inscripciones'));
}

public function aceptarSolicitudEmprendimiento($id)
{
    $temp = TempEmprendimiento::findOrFail($id);

    $logoNombre = $temp->logo ? basename($temp->logo) : null;
    $origen = 'emprendimientos_temp/' . $logoNombre;
    $destino = 'images/emprendimientos/' . $logoNombre;

    if ($logoNombre && \Storage::disk('public')->exists($origen)) {
        \Storage::disk('public')->move($origen, $destino);
    }

    Emprendimiento::create([
        'id_users'       => $temp->id_users,
        'nombre'         => $temp->nombre_emprendimiento,
        'emprendimiento' => $temp->nombre_comercial,
        'descripcion'    => $temp->descripcion,
        'telefono'       => $temp->telefono ?? 'Sin teléfono',
        'redes'          => $temp->redes ?? 'Sin redes',
        'ubicacion'      => $temp->ubicacion ?? 'Sin ubicación',
        'logo'           => $logoNombre,
    ]);

    $temp->delete();

    return back()->with('success', 'Emprendimiento aceptado correctamente.');
    
}



public function aceptarSolicitud($id)
{
    $temp = TempProduct::findOrFail($id);

    $fotos = is_array($temp->fotosproduct)
        ? $temp->fotosproduct
        : json_decode($temp->fotosproduct, true);

    if ($fotos && count($fotos) > 0) {
        foreach ($fotos as $fotoNombre) {
            $origen = "temp_products/$fotoNombre";
            $destino = "images/productos/$fotoNombre";

            if (Storage::disk('public')->exists($origen)) {
                Storage::disk('public')->move($origen, $destino);
            }
        }
    }

    // crear registro definitivo
    $producto = new Producto();
    $producto->id_users = $temp->id_users;
    $producto->id_emprendimiento = $temp->id_emprendimiento;
    $producto->nombreproducto = $temp->nombreproducto;
    $producto->descripcion = $temp->descripcion;
    $producto->precio = $temp->precio;
    $producto->fotosproduct = $temp->fotosproduct; 
    $producto->estado = 'activo';
    $producto->save();

    $temp->delete();

    return back()->with('success', 'Producto aceptado correctamente.');
}

}