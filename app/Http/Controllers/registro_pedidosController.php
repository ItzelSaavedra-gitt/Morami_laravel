<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class registro_pedidosController
{
    public function MiInterfaz9(){
        return view("registro_pedidos");
    }

    public function Guardar(Request $request){
        $request->validate([
            'nombre_cliente'  => 'required|string|max:100',
            'apellidoP'       => 'required|string|max:100',
            'apellidoM'       => 'nullable|string|max:100',
            'direccion'       => 'required|string|max:200',
            'municipio'       => 'required|string|max:100',
            'tel'             => 'required|string|max:20',
            'vendedor'        => 'required|string|max:100',
            'fecha'           => 'required|date',
            'nombre_producto' => 'required|string|max:100',
            'material'        => 'required',
            'medida'          => 'required',
            'cantidad'        => 'required|integer|min:1',
            'precio'          => 'required|numeric|min:0',
            'fletes'          => 'nullable|numeric|min:0',
        ]);

        $subtotal = $request->cantidad * $request->precio;
        $fletes   = $request->fletes ?: 0;
        $total    = $subtotal + $fletes;

        try {
            DB::connection('mysql')->transaction(function () use ($request, $subtotal, $fletes, $total) {

                $idPedido = DB::connection('mysql')->table('pedidos')->insertGetId([
                    'fecha_ped'         => $request->fecha,
                    'fechaEntrega_ped'  => null,
                    'estatus_ped'       => 'Pendiente',
                    'nombreCliente_ped' => $request->nombre_cliente,
                    'apellidoP_ped'     => $request->apellidoP,
                    'apellidoM_ped'     => $request->apellidoM ?: null,
                    'direccion_ped'     => $request->direccion,
                    'municipio_ped'     => $request->municipio,
                    'telefono_ped'      => $request->tel,
                    'vendedor_ped'      => $request->vendedor,
                    'fletes_ped'        => $fletes,
                    'total_ped'         => $total,
                ]);

                DB::connection('mysql')->table('detalle_pedidos')->insert([
                    'id_ped_fk'          => $idPedido,
                    'nombreProducto_det' => $request->nombre_producto,
                    'tipo_det'           => $request->material,
                    'unidadMedida_det'   => $request->medida,
                    'cantidad_det'       => $request->cantidad,
                    'precioUnitario_det' => $request->precio,
                    'subtotal_det'       => $subtotal,
                ]);
            });
        }
        catch (\Exception $e) {
            return back()->withInput()->with('error', 'No se pudo guardar: ' . $e->getMessage());
        }

        return redirect('/pedido')->with('ok', 'El pedido se guardó con éxito');
    }
}

