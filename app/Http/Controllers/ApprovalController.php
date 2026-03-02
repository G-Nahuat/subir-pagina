<?php

namespace App\Http\Controllers;

use App\Mail\RecepcionSolicitud;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApprovalController extends Controller
{
    public function approve($solicitudId)
    {
        // Encontrar la solicitud
        $solicitud = Solicitud::findOrFail($solicitudId);
        
        // Actualizar estado
        $solicitud->estado = 'aprobado';
        $solicitud->save();
        
        // Enviar email de notificación
        Mail::to($solicitud->email)->send(new RecepcionSolicitud($solicitud->email));
        
        // Redirigir con mensaje de éxito
        return back()->with('success', 'Solicitud aprobada y usuario notificado.');
    }
}   