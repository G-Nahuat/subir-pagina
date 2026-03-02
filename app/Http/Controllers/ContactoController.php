<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function mostrarFormulario()
    {
        return view('contacto.formulario');
    }

    public function enviarCorreo(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email',
            'mensaje' => 'required|string|max:1000',
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'mensaje' => $request->mensaje,
        ];

        Mail::send('contacto.email', $datos, function ($message) use ($datos) {
            $message->from('emprender.semujeres@qroo.gob.mx', 'Mujer Es Emprender');
            $message->to('edgarhaas519@gmail.com', 'Edgar Leonel');
            $message->subject('📬 Nuevo mensaje desde el formulario');
            $message->replyTo($datos['correo'], $datos['nombre']); 
        });

        return back()->with('success', '¡Tu mensaje fue enviado a edgarhaas519@gmail.com correctamente!');
    }
}
