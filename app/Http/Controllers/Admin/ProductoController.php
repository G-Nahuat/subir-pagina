<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Mail;
use App\Mail\ProductoAceptadoMail;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\TempProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DatosGenerales; 

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::paginate(10);
        return view('admin.productos.index', compact('productos'));
        $productos = Producto::with(['usuario.datosGenerales', 'emprendimiento'])->paginate(10);
    return view('admin.productos.index', compact('productos'));
    }


 public function aceptarSolicitud($id)
{
    $temp = TempProduct::findOrFail($id);

    // Procesar fotos
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

    // Crear producto definitivo
    $producto = new Producto();
    $producto->id_users = $temp->id_users;
    $producto->id_emprendimiento = $temp->id_emprendimiento;
    $producto->nombreproducto = $temp->nombreproducto;
    $producto->descripcion = $temp->descripcion;
    $producto->precio = $temp->precio;
    $producto->fotosproduct = $temp->fotosproduct;
    $producto->estado = 'activo';
    $producto->save();

    // Obtener datos del usuario
    $datos = \App\Models\DatosGenerales::where('id_users', $producto->id_users)->first();

    if ($datos && $datos->email) {
        // Concatenar nombre completo
        $nombre_completo = trim("{$datos->nombre} {$datos->apellido_paterno} {$datos->apellido_materno}");

        // Enviar correo con nombre completo
        Mail::to($datos->email)->send(new \App\Mail\ProductoAceptadoMail($producto, $nombre_completo));
    }

    // Eliminar el producto temporal
    $temp->delete();

    return back()->with('success', 'Producto aceptado correctamente.');
}






public function rechazarSolicitud(Request $request, $id)
{
    $request->validate([
        'razon' => 'required|string|max:255'
    ]);

    $temp = TempProduct::findOrFail($id);

    $fotos = is_array($temp->fotosproduct)
        ? $temp->fotosproduct
        : json_decode($temp->fotosproduct, true);

    if ($fotos && count($fotos) > 0) {
        foreach ($fotos as $foto) {
            $ruta = "temp_products/$foto";
            if (Storage::disk('public')->exists($ruta)) {
                Storage::disk('public')->delete($ruta);
            }
        }
    }

    $datos = DatosGenerales::where('id_users', $temp->id_users)->first();
    if ($datos && $datos->email) {
        $nombre_completo = trim("{$datos->nombre} {$datos->apellido_paterno} {$datos->apellido_materno}");
        Mail::to($datos->email)->send(new \App\Mail\ProductoRechazadoMail($temp, $nombre_completo, $request->razon));
    }

    $temp->delete();

    return back()->with('success', 'Producto rechazado y notificación enviada.');
}





}