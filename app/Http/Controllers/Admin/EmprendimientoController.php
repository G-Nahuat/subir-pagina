<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;

use App\Models\EmprendimientoTemp; 
use Illuminate\Http\Request;


class EmprendimientoController extends Controller
{
    public function index()
    {
        $emprendimientos = Emprendimiento::all();
        return view('admin.emprendimientos.index', compact('emprendimientos'));
    }


    // Muestra todas las solicitudes pendientes
    public function solicitudes()
    {
        $solicitudes = EmprendimientoTemp::all();
        return view('admin.solicitudes_emprendimientos.index', compact('solicitudes'));
    }

    // Ver detalle de una solicitud
    public function verSolicitud($id)
    {
        $solicitud = EmprendimientoTemp::findOrFail($id);
        return view('admin.solicitudes_emprendimientos.show', compact('solicitud'));
    }

    // Acepta la solicitud
    public function aceptarSolicitud($id)
    {
        $sol = EmprendimientoTemp::findOrFail($id);
        // tu lógica: p.ej. crear un Emprendimiento definitivo...
        $sol->delete(); // y luego la eliminas
        return redirect()->route('admin.emprendimientos.solicitudes.index')
                         ->with('success','Solicitud aceptada');
    }

    // Rechaza la solicitud
    public function rechazarSolicitud($id)
    {
        $sol = EmprendimientoTemp::findOrFail($id);
        $sol->delete();
        return redirect()->route('admin.emprendimientos.solicitudes.index')
                         ->with('warning','Solicitud rechazada');
    }
}


