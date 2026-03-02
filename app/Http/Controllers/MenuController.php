<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Muestra la vista del menú interactivo.
     */
    public function index()
    {
       
        return view('menu');
    }
}
