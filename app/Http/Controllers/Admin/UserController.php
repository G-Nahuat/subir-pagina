<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
    

class UserController extends Controller
{
    public function index()         
    {
        $users = User::with('datosGenerales')->paginate(10);
        return view('admin.usuarios.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('datosGenerales')->findOrFail($id);
        return view('admin.usuarios.show', compact('user'));
    }
}
