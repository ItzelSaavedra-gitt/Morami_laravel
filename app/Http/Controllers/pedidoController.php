<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class pedidoController 
{
    public function MiInterfaz6(){
        try {
            $resPedido = DB::connection('mysql') 
            ->table('pedidos')
            ->select('id_ped_pk', 'fecha_ped', 'fechaEntrega_ped','estatus_ped')
            ->get();
            
            $titulo="Grupo Morami";
            //return "Cargando ususarios";
            return view("pedido",compact('titulo'),compact('resPedido'));
        
         }
        catch(\Exception $e){
            response("Error al consultar la base de datos:".$e->getMessage(), 500);
            
        }

    }
}
