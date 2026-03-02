<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\DatosGenerales;

class LoginController extends Controller
{

    
    // Mostrar el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar el login
    public function loginCorreo(Request $request)
    {
        $request->validate([
            'login_type'  => 'required|in:correo,curp',
            'login_value' => 'required|string',
            'password'    => 'required|string',
        ]);

        $field = $request->login_type === 'correo' ? 'email' : 'curp';

        $datos = DatosGenerales::where($field, $request->login_value)->first();

        if (! $datos || ! $datos->user) {
            return back()->withErrors(['login_value' => 'Credenciales inválidas']);
        }

        $user = $datos->user;

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Contraseña incorrecta']);
        }

        Auth::login($user);

        // Comparación segura por string (por si tipo es string)
        if ((string) $user->tipo === '1') {
            return redirect()->route('admin.dashboard');
        }

        session()->flash('mostrar_bienvenida', true);

        return redirect()->route('perfil.index');
    }
}