<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class panelController
{
    public function MiInterfaz4(){
        // Solo entra quien haya iniciado sesión
        if (!session()->has('usuario_id')) {
            return redirect('/login');
        }
        return view("panel");
    }
}
