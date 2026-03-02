<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Sección: Método home
     * Función: Renderiza la vista principal con todos los datos necesarios
     */
    public function home()
    {
        // Llamada separada a la base de datos para obtener items del menú
        $menuItems = $this->fetchMenuItems();

        // Retorna la vista 'home' con los datos de menú
        return view('home', compact('menuItems'));
    }

    /**
     * Sección: Método fetchMenuItems
     * Función: Obtiene los elementos del menú desde la base de datos
     * Nota: Reemplazar el placeholder con la consulta real a tu modelo MenuItem
     * Ejemplo:
     * return \App\Models\MenuItem::where('active', 1)
     *     ->orderBy('order')
     *     ->get()
     *     ->toArray();
     *
     * @return array
     */
    private function fetchMenuItems()
    {
        // Placeholder temporal; sustituir con consulta Eloquent real
        return [
            ['icon' => 'fas fa-user-tie',   'label' => 'Perfil',         'url' => '#'],
            ['icon' => 'fas fa-briefcase',   'label' => 'Negocio',        'url' => '#'],
            ['icon' => 'fas fa-file-alt',    'label' => 'Documentación',  'url' => '#'],
            ['icon' => 'fas fa-sign-out-alt','label' => 'Salir',          'url' => '#'],
        ];
    }
}
// ya no jala pero si la quito explota xd