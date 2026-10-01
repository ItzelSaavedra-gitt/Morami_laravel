<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;


class productosregistradosController extends Controller
{
    
    public function MiInterfaz7(){
        
        
        try {
            $resProducto = DB::connection('mysql') 
            ->table('productos')
            ->select('nombre_pro', 'color_pro', 'tipo_pro','formato_pro','CantidadPiezas_pro','unidadMedida', 'fechaCaducidad', 'precioUnitario_pro')
            ->get();
            
            $titulo="Grupo Morami";
            //return "Cargando ususarios";
            return view("productosregistrados",compact('titulo'),compact('resProducto'));
        
         }
        catch(\Exception $e){
            response("Error al consultar la base de datos:".$e->getMessage(), 500);
            
        }

        //foreach($res2Usuario as $dato){
        //    //echo $dato->nombre_completo."<br>".
        //    #$dato->nombre_usuario;
        //}
       
    }

    
}
