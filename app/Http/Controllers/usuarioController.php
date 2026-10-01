<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RecursiveArrayIterator;

class usuarioController extends Controller
{
    
    public function MiInterfaz1(){
        
        try {
            $res2Usuario = DB::connection('mysql') 
            ->table('usuarios')
            ->select('id_usu_pk', 'nombre', 'apellidoPaterno','apellidoMaterno','usuario','contrasenia')
            ->get();
            
            $titulo="Grupo Morami";
            //return "Cargando ususarios";
            return view("usuario",compact('titulo'),compact('res2Usuario'));
        
         }
        catch(\Exception $e){
            response("Error al consultar la base de datos:".$e->getMessage(), 500);
            
        }

        //foreach($res2Usuario as $dato){
        //    //echo $dato->nombre_completo."<br>".
        //    #$dato->nombre_usuario;
        //}
       
    }

    //public function MyLogin(){
    //   return view ("login", compact('titulo'));
    //}
//
    //public function InicioSesion(Request $request){
    //    $usuario =$request->input('usuario');
    //    $contrasennia =$request->input('contrasennia');
//
//
//
    //    try {
    //        $res2Usuario = DB::connection('mysql') 
    //        ->table('usuarios')
    //        ->select('id', 'nombre_completo', 'nombre_usuario','contrasennia')
    //        ->where('nombre_usuario','=',$usuario)
    //        ->where('contrasennia', '=', $contrasennia)
    //        ->first();
    //        redirect()->route('miinterfaz');
    //        
    //        $titulo="Seguros Azteca";
    //        //return "Cargando ususarios";
    //        return view("usuario",compact('titulo'),compact('res2Usuario'));
    //    
    //     }
    //    catch(\Exception $e){
    //        redirect()->route('login')->with('error','Error al ingresar');
    //        return;
    //    }
    //}
}//