<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class cotizacionController
{
    // Nombre completo del cliente a partir de las columnas de la tabla clientes
    private function expresionCliente(bool $hayClientes): string
    {
        if ($hayClientes) {
            try {
                $partes = [];
                foreach (Schema::connection('mysql')->getColumnListing('clientes') as $col) {
                    if (preg_match('/^(nombre|apellido)/i', $col)) {
                        $partes[] = 'cl.`' . str_replace('`', '', $col) . '`';
                    }
                }
                if ($partes) {
                    return "TRIM(CONCAT_WS(' ', " . implode(', ', $partes) . "))";
                }
            } catch (\Throwable $e) {
            }
        }
        return "CONCAT('Cliente ', c.id_cli_pk)";
    }

    public function MiInterfaz(Request $request){
        // Solo entra quien haya iniciado sesión
        if (!session()->has('usuario_id')) {
            return redirect('/login');
        }

        $busqueda = trim((string) $request->input('q', ''));

        try {
            $hayClientes = Schema::connection('mysql')->hasTable('clientes');
            $cliente  = $this->expresionCliente($hayClientes);
            $vendedor = "TRIM(CONCAT_WS(' ', u.nombre, u.apellidoPaterno, u.apellidoMaterno))";

            $consulta = DB::connection('mysql')->table('cotizaciones as c');

            if ($hayClientes) {
                $consulta->leftJoin('clientes as cl', 'cl.id_cli_pk', '=', 'c.id_cli_pk');
            }
            $consulta->leftJoin('usuarios as u', 'u.id_usu_pk', '=', 'c.id_usu_pk');

            $consulta->select('c.id_cot_pk', 'c.fecha_cot', 'c.total_cot', 'c.fechaVencimiento_cot', 'c.id_cli_pk', 'c.id_usu_pk');
            $consulta->selectRaw($cliente . ' as cliente_cot');
            $consulta->selectRaw($vendedor . ' as vendedor_cot');

            if ($busqueda !== '') {
                $like = '%' . $busqueda . '%';
                $consulta->whereRaw(
                    "($cliente LIKE ? OR $vendedor LIKE ? OR c.id_cot_pk LIKE ? OR c.fecha_cot LIKE ? OR c.fechaVencimiento_cot LIKE ?)",
                    [$like, $like, $like, $like, $like]
                );
            }

            $resCotizacion = $consulta->orderBy('c.id_cot_pk', 'desc')->get();
        }
        catch (\Throwable $e) {
            return response("Error al consultar la base de datos: " . $e->getMessage(), 500);
        }

        $titulo = "Grupo Morami";
        return view("cotizacion", compact('titulo', 'resCotizacion', 'busqueda'));
    }
}