<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class inventarioController
{
    public function MiInterfaz2(Request $request)
    {
        // Solo entra quien haya iniciado sesión
        if (!session()->has('usuario_id')) {
            return redirect('/login');
        }

        $tipoSeleccionado = trim((string) $request->input('tipo', ''));
        $estadoFiltro = trim((string) $request->input('estado_stock', ''));

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

            // Inventario = productos activos con su cantidad y umbrales de stock
            $consulta = $db->table('productos')
                ->select(
                    'id_pro_pk',
                    'nombre_pro',
                    'tipo_pro',
                    'color_pro',
                    'CantidadPiezas_pro',
                    'stock_actual',
                    'stock_minimo',
                    'stock_maximo',
                    'rendimiento_caja_pro',
                    'formato_pro',
                    'unidadMedida',
                    'fechaCaducidad',
                    'es_sobre_pedido'
                )
                ->where('estado_pro', '1');

            if ($tipoSeleccionado !== '') {
                $consulta->where('tipo_pro', $tipoSeleccionado);
            }

            $resInventario = $consulta->orderBy('nombre_pro')->get()->map(function ($item) {
                $cantidadEfectiva = (int) ($item->stock_actual ?? $item->CantidadPiezas_pro ?? 0);
                $minimo = !is_null($item->stock_minimo) ? (int) $item->stock_minimo : null;
                $maximo = !is_null($item->stock_maximo) ? (int) $item->stock_maximo : null;

                if ((bool) $item->es_sobre_pedido) {
                    $estadoStock = 'sobre_pedido';
                } elseif (!is_null($minimo) && $cantidadEfectiva <= $minimo) {
                    $estadoStock = 'stock_bajo';
                } elseif (!is_null($maximo) && $cantidadEfectiva >= $maximo) {
                    $estadoStock = 'stock_alto';
                } else {
                    $estadoStock = 'normal';
                }

                $item->cantidad_efectiva = $cantidadEfectiva;
                $item->estado_stock = $estadoStock;

                return $item;
            });

            if ($estadoFiltro !== '') {
                $resInventario = $resInventario->where('estado_stock', $estadoFiltro)->values();
            }
        } catch (\Throwable $e) {
            return response("Error al consultar la base de datos: " . $e->getMessage(), 500);
        }

        $titulo = "Grupo Morami";
        return view("inventario", compact(
            'titulo',
            'resInventario',
            'tipos',
            'tipoSeleccionado',
            'estadoFiltro'
        ));
    }
}