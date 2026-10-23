<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class inventarioController
{
    public function MiInterfaz2(Request $request){
        // Solo entra quien haya iniciado sesión
        if (!session()->has('usuario_id')) {
            return redirect('/login');
        }

        $tipoSeleccionado = trim((string) $request->input('tipo', ''));

        try {
            $db = DB::connection('mysql');

            // Tipos para el filtro (solo productos activos)
            $tipos = $db->table('productos')
                ->where('estado_pro', '1')
                ->whereNotNull('tipo_pro')
                ->where('tipo_pro', '<>', '')
                ->distinct()
                ->orderBy('tipo_pro')
                ->pluck('tipo_pro');

            // Inventario = productos activos con su cantidad de piezas
            $consulta = $db->table('productos')
                ->select('id_pro_pk', 'nombre_pro', 'tipo_pro', 'color_pro', 'CantidadPiezas_pro',
                         'formato_pro', 'unidadMedida', 'fechaCaducidad')
                ->where('estado_pro', '1');

            if ($tipoSeleccionado !== '') {
                $consulta->where('tipo_pro', $tipoSeleccionado);
            }

            $resInventario = $consulta->orderBy('nombre_pro')->get();
        }
        catch (\Throwable $e) {
            return response("Error al consultar la base de datos: " . $e->getMessage(), 500);
        }

        $titulo = "Grupo Morami";
        return view("inventario", compact('titulo', 'resInventario', 'tipos', 'tipoSeleccionado'));
    }
}