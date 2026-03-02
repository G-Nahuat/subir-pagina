<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Asistente;
use Illuminate\Support\Facades\Auth;

class AsistenteEventoController extends Controller
{
    
    public function inscribirse($id)
    {
        $user = Auth::user();
        $datos = $user->datosGenerales;

        if (!$datos || !$datos->email) {
            return redirect()->back()->with('error', 'Debes completar tu perfil con un correo electrónico.');
        }

        $yaInscrito = Asistente::where('id_evento', $id)
            ->where('email', $datos->email)
            ->exists();

        if ($yaInscrito) {
            return redirect()->back()->with('error', 'Ya estás inscrita en este evento.');
        }

        Asistente::create([
            'id_evento' => $id,
            'id_users' => $user->id_users,
            'nombre_completo' => $datos->nombre . ' ' . $datos->apellido_paterno . ' ' . $datos->apellido_materno,
            'curp' => $datos->curp,
            'telefono' => $datos->telefono,
            'email' => $datos->email
        ]);

        return redirect()->back()->with('success', 'Te has inscrito correctamente al evento.');
    }
}
