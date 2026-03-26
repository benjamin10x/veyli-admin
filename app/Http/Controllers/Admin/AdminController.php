<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.index');
    }
    
    public function module(string $module)
    {
        return view($module . '.index');
    }

    public function enviosRegistrar()
    {
        return view('envios.registrar');
    }

    public function rutasAsignar()
    {
        return view('rutas.asignar');
    }

}
