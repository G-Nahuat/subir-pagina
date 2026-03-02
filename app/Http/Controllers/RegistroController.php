<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\DatosGenerales;
use App\Models\DatosLaborales;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\CatalogoGradoEstudios;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\RegistroTemporal;
use Illuminate\Auth\Events\Registered;
use App\Mail\VerificaCorreoTemporal;
use App\Mail\VerificacionCorreo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    public function create()
    {
        $grados = CatalogoGradoEstudios::all();
        $municipios = Municipio::orderBy('municipio')->get();
        return view('eventos.registro', compact('grados', 'municipios'));
    }

    public function getMunicipios($estado_id)
    {
        $municipios = Municipio::where('estado_id', $estado_id)->get();
        return response()->json($municipios);
    }

    public function store(Request $request)
{
    $request->validate([
        'password' => 'required|min:6|confirmed',
        'email' => 'required|email|unique:registro_temporal,email|unique:users,email',
        'foto_ine.*' => 'required|file|mimes:pdf|max:8192',
        'edad' => 'required|numeric|min:10|max:120',
    ]);

    // Crear usuario tipo 2 (vendedor) — NO iniciar sesión aquí
    $user = User::create([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'tipo' => 2,
    ]);

    // Subir PDF del INE
    $inePaths = [];
    if ($request->hasFile('foto_ine')) {
        foreach ($request->file('foto_ine') as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/ine', $filename);
            $inePaths[] = 'storage/ine/' . $filename;
        }
    }

    // Guardar datos 
    RegistroTemporal::create([
        'id_users' => $user->id_users,
        'nombre' => $request->nombre,
        'apellido_paterno' => $request->primer_apellido,
        'apellido_materno' => $request->segundo_apellido,
        'curp' => $request->curp,
        'telefono' => $request->telefono,
        'email' => $request->email,
        'edad' => $request->edad,
        'ine' => json_encode($inePaths),
        'id_municipio' => $request->municipio_id,
        'id_ultimo_grado' => $request->grado_estudios,
    ]);

    // Crear solicitud pendiente
    Solicitud::create([
        'id_users' => $user->id_users,
        'estatus' => 'pendiente',
        'fecha_solicitud' => now(),
    ]);

    // Generar link firmado para verificar el correo
    $signedUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id_users, 'hash' => sha1($user->email)]
    );

    // Enviar el correo de verificación
    try {
        Mail::to($user->email)->send(new VerificaCorreoTemporal($user, $signedUrl));
        \Log::info('Correo de verificación enviado a: ' . $user->email);
    } catch (\Exception $e) {
        \Log::error('Error al enviar correo de verificación: ' . $e->getMessage());
    }

    // Iniciar sesión temporal para permitir validación sin redirigir a login
    Auth::login($user);

    // Guardar email en sesión 
    session(['email_verificacion' => $user->email]);

    return view('auth.verifica', ['email' => $user->email]);
}

public function validarCorreo(Request $request)
{
    $correo = $request->input('email');
    $existe = \App\Models\User::where('email', $correo)->exists();

    return response()->json(['disponible' => !$existe]);
}

}