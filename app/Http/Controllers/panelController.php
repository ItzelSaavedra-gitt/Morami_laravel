<?php

namespace App\Http\Controllers;

use App\Models\cotizacionModel;
use App\Models\pedidoModel;
use App\Models\productosregistradosModel;
use App\Models\usuariolModel;
use Illuminate\Support\Facades\DB;

class panelController
{
    public function MiInterfaz4(){
        // Solo entra quien haya iniciado sesión
        if (!session()->has('usuario_id')) {
            return redirect('/login');
        }

        try {
            // ---------- Tarjetas ----------
            $totalUsuarios     = usuariolModel::count();
            $totalCotizaciones = cotizacionModel::count();
            $totalProductos    = productosregistradosModel::where('estado_pro', '1')->count();

            // ---------- Gráfica de barras: pedidos por estatus ----------
            $estatus = ['Pendiente' => 0, 'Proceso' => 0, 'Completado' => 0];

            $filas = pedidoModel::select('estatus_ped', DB::raw('COUNT(*) as total'))
                ->groupBy('estatus_ped')
                ->get();

            foreach ($filas as $f) {
                // Acepta "Completado" o "Entregado", y "Proceso" o "En proceso"
                $valor = mb_strtolower(trim((string) $f->estatus_ped));

                if ($valor === 'pendiente') {
                    $estatus['Pendiente'] += (int) $f->total;
                } elseif (in_array($valor, ['proceso', 'en proceso'], true)) {
                    $estatus['Proceso'] += (int) $f->total;
                } elseif (in_array($valor, ['completado', 'completada', 'entregado', 'entregada'], true)) {
                    $estatus['Completado'] += (int) $f->total;
                }
            }

            $totalPendientes = $estatus['Pendiente'];

            // ---------- Gráfica de dona: piezas en existencia por categoría ----------
            $existencia = productosregistradosModel::select('tipo_pro', DB::raw('SUM(CantidadPiezas_pro) as total'))
                ->where('estado_pro', '1')
                ->groupBy('tipo_pro')
                ->havingRaw('SUM(CantidadPiezas_pro) > 0')
                ->orderByDesc('total')
                ->get()
                ->map(fn($p) => [
                    'categoria' => $p->tipo_pro ?: 'Sin categoría',
                    'total'     => (int) $p->total,
                ])
                ->all();
        }
        catch (\Throwable $e) {
            return response("Error al consultar la base de datos: " . $e->getMessage(), 500);
        }

        return view("panel", compact(
            'totalUsuarios',
            'totalCotizaciones',
            'totalPendientes',
            'totalProductos',
            'existencia',
            'estatus'
        ));
    }
}