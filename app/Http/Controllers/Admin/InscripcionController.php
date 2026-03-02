<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use App\Models\RegistroTemporal;
use App\Models\DatosGenerales;
use App\Models\DatosLaborales;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\AsistenteCurso;
use Illuminate\Support\Facades\Mail;
use App\Mail\CuentaAprobada;




class InscripcionController extends Controller
{
    public function index()
    {
        $solicitudes = Solicitud::with('usuario.RegistroTemporal')->paginate(10);
        return view('admin.inscripciones.index', compact('solicitudes'));
    }

    public function verSolicitudes()
{
    $solicitudes = Solicitud::with('usuario.datosGenerales')->where('estatus', 'pendiente')->get();
    return view('admin.usuarios.solicitudes', compact('solicitudes'));
}

public function verDetalle($id_users)
{
     $registro = RegistroTemporal::with(['estado', 'municipio', 'gradoEstudios'])
        ->where('id_users', $id_users)
        ->first();

    if (!$registro) {
        return back()->with('error', 'Datos no encontrados.');
    }

    return view('admin.usuarios.detalles', compact('registro'));
}

public function mostrar($id_users)
{
    $registro = \App\Models\RegistroTemporal::where('id_users', $id_users)->first();

    if (!$registro) {
        return back()->with('error', 'Datos no encontrados');
    }

    return view('admin.usuarios.detalle', compact('registro'));
}

public function aprobar($id)
{
    $temp = RegistroTemporal::where('id_users', $id)->firstOrFail();

    // VERIFICAR SI YA EXISTE UN USUARIO CON ESTE EMAIL
    $userExistente = User::where('email', $temp->email)->first();

    if ($userExistente) {
        // USUARIO EXISTENTE - ACTUALIZAR
        $userExistente->update([
            'tipo' => 2,
            'email_verified_at' => now(),
        ]);

        $userId = $userExistente->id_users;
    } else {
        // USUARIO NUEVO - CREAR
        $user = User::create([
            'email' => $temp->email,
            'password' => Hash::make($temp->password),
            'tipo' => 2,
            'email_verified_at' => now(),
        ]);

        $userId = $user->id_users;
    }

    // VERIFICAR SI YA EXISTEN DATOS GENERALES PARA ESTE USUARIO
    $datosExistentes = DatosGenerales::where('id_users', $userId)->first();

    if ($datosExistentes) {
    $datosExistentes->update([
        'nombre' => $temp->nombre,
        'apellido_paterno' => $temp->apellido_paterno,
        'apellido_materno' => $temp->apellido_materno,
        'curp' => $temp->curp,
        'telefono' => $temp->telefono,
        'email' => $temp->email,
        'id_municipio' => $temp->id_municipio,
        'id_ultimo_grado' => $temp->id_ultimo_grado,
        'edad' => $temp->edad,
        'ine' => $temp->ine,
    ]);
} else {
    DatosGenerales::create([
        'id_users' => $userId,
        'nombre' => $temp->nombre,
        'apellido_paterno' => $temp->apellido_paterno,
        'apellido_materno' => $temp->apellido_materno,
        'curp' => $temp->curp,
        'telefono' => $temp->telefono,
        'email' => $temp->email,
        'id_municipio' => $temp->id_municipio,
        'id_ultimo_grado' => $temp->id_ultimo_grado,
        'edad' => $temp->edad,
        'ine' => $temp->ine,
    ]);
}


    // Actualizar la solicitud
    $solicitud = Solicitud::where('id_users', $id)->first();
    if ($solicitud) {
        $solicitud->id_users = $userId;
        $solicitud->estatus = 'aceptado';
        $solicitud->save();
    }

    // Enviar correo de aprobación
    try {
        Mail::to($temp->email)->send(new CuentaAprobada($temp->nombre));
    } catch (\Exception $e) {
        // Puedes guardar log si falla el envío
        \Log::error("Error al enviar correo de cuenta aprobada: " . $e->getMessage());
    }

    // Eliminar el temporal
    $temp->delete();

    return redirect()->route('admin.solicitudes-usuarios.index')
        ->with('success', 'Usuario registrado y notificado por correo correctamente.');
}

public function rechazar($id_users)
{
    $solicitud = Solicitud::where('id_users', $id_users)->first();
    if ($solicitud) {
        $solicitud->delete();
    }

    $temp = RegistroTemporal::where('id_users', $id_users)->first();
    if ($temp) {
        $temp->delete();
    }

    return back()->with('error', 'Solicitud rechazada y datos eliminados');
}

public function inscribirme($id)
{
    $usuario = Auth::user();

    // Validar que el usuario está autenticado
    if (!$usuario) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para inscribirte.');
    }

    // Verificar si ya está inscrito en ese curso
    $existe = AsistenteCurso::where('id_curso', $id)
                ->where('correo', $usuario->datosGenerales->email)
                ->first();

    if ($existe) {
        return redirect()->back()->with('error', 'Ya estás inscrito en este curso.');
    }

    // Crear nuevo registro
    AsistenteCurso::create([
        'id_curso' => $id,
        'nombre' => $usuario->datosGenerales->nombre,
        'edad' => $usuario->datosGenerales->edad ?? null,
        'telefono' => $usuario->datosGenerales->telefono ?? null,
        'correo' => $usuario->datosGenerales->email,
        'asistio' => 0,
        'constancia_emitida' => 0,
        'fecha_registro' => now(),
    ]);

    return redirect()->back()->with('success', 'Te has inscrito correctamente al curso.');
}


}