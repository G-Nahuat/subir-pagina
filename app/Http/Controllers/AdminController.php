<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\TempProduct;


class AdminController extends Controller
{
     public function dashboard()
{
    
    $userCount = \App\Models\User::count(); // o ya tienes importado User
    $pendingCount = Solicitud::where('estatus', 'pendiente')->count();

    return view('admin.dashboard', compact('userCount'));
}

public function cargarVista($seccion)
{
    switch ($seccion) {
        case 'usuarios':
            $users = \App\Models\User::with('datosGenerales')->paginate(15);
            return view('admin.usuarios.index', compact('users'));

        case 'eventos':
            $eventos = \App\Models\Evento::orderBy('fecha','desc')->paginate(15);
            return view('admin.eventos.index', compact('eventos'));

        case 'inscripciones':
            $solicitudes = \App\Models\Solicitud::with('user')->paginate(15);
            return view('admin.inscripciones.index', compact('solicitudes'));

        case 'productos':
            $productos = \App\Models\Producto::paginate(15);
            return view('admin.productos.index', compact('productos'));

        case 'solicitudes-productos':
        $solicitudes = TempProduct::with('usuario.datosGenerales', 'emprendimiento')->get();
        return view('admin.productos.solicitudes', compact('solicitudes'));


        default:
            abort(404, 'Sección no encontrada');
    }
}

}