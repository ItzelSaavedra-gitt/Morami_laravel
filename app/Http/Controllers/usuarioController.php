<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RecursiveArrayIterator;

class usuarioController extends Controller
{
    private $columnas = ['id_usu_pk', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'usuario', 'contrasenia', 'id_rol'];

    // Verifica que haya sesión iniciada; si no, manda al login
    private function sinSesion(){
        return !session()->has('usuario_id');
    }

    
    public function MiInterfaz1(){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        try {
            $res2Usuario = DB::connection('mysql')
            ->table('usuarios')
            ->select($this->columnas)
            ->get();

            $titulo="Grupo Morami";
            return view("usuario",compact('titulo'),compact('res2Usuario'));
        }
        catch(\Exception $e){
            return response("Error al consultar la base de datos: ".$e->getMessage(), 500);
        }
    }

    
    public function buscarusuario(Request $request){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        $q = trim((string) $request->input('q'));

        try {
            $consulta = DB::connection('mysql')->table('usuarios')->select($this->columnas);

            if ($q !== '') {
                $consulta->where(function ($w) use ($q) {
                    $w->where('nombre', 'like', "%{$q}%")
                      ->orWhere('apellidoPaterno', 'like', "%{$q}%")
                      ->orWhere('apellidoMaterno', 'like', "%{$q}%")
                      ->orWhere('usuario', 'like', "%{$q}%");
                });
            }

            $res2Usuario = $consulta->get();
            $titulo="Grupo Morami";
            $busqueda = $q;
            return view("usuario", compact('titulo', 'res2Usuario', 'busqueda'));
        }
        catch(\Exception $e){
            return response("Error al consultar la base de datos: ".$e->getMessage(), 500);
        }
    }

    public function vistacrear(){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
        $usuario = null;
        return view("registro_usu", compact('usuario'));
    }

    
    public function guardarusuario(Request $request){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'usuario'          => 'required|string|max:100',
            'id_rol'           => 'required|in:1,2',
            'password'         => 'required|string|min:4|max:100',
        ]);

        try {
            $existe = DB::connection('mysql')->table('usuarios')
                ->where('usuario', $request->usuario)->exists();

            if ($existe) {
                return back()->withInput()->with('error', 'El nombre de usuario ya existe, elige otro');
            }

            DB::connection('mysql')->table('usuarios')->insert([
                'nombre'          => $request->nombre,
                'apellidoPaterno' => $request->apellido_paterno,
                'apellidoMaterno' => $request->apellido_materno ?: null,
                'usuario'         => $request->usuario,
                'id_rol'          => $request->id_rol,
                'contrasenia'     => Hash::make($request->password),
            ]);
        }
        catch (\Exception $e) {
            return back()->withInput()->with('error', 'No se pudo guardar: ' . $e->getMessage());
        }

        return redirect()->route('usuarios.index')->with('ok', 'El usuario se registró con éxito');
    }

    
    public function vistaeditar($id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        try {
            $usuario = DB::connection('mysql')->table('usuarios')
                ->select($this->columnas)->where('id_usu_pk', $id)->first();
        }
        catch (\Exception $e) {
            return response("Error al consultar la base de datos: ".$e->getMessage(), 500);
        }

        if (!$usuario) {
            return redirect()->route('usuarios.index')->with('error', 'El usuario no existe');
        }

        return view("registro_usu", compact('usuario'));
    }

    
    public function editarusuario($id){
        if ($this->sinSesion()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $usuario = DB::connection('mysql')->table('usuarios')
            ->select('id_usu_pk', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'usuario')
            ->where('id_usu_pk', $id)->first();

        if (!$usuario) {
            return response()->json(['error' => 'El usuario no existe'], 404);
        }
        return response()->json($usuario);
    }

   
    public function actualizarusuario(Request $request, $id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'usuario'          => 'required|string|max:100',
            'id_rol'           => 'required|in:1,2',
            'password'         => 'nullable|string|min:4|max:100',
        ]);

        try {
            $repetido = DB::connection('mysql')->table('usuarios')
                ->where('usuario', $request->usuario)
                ->where('id_usu_pk', '<>', $id)->exists();

            if ($repetido) {
                return back()->withInput()->with('error', 'El nombre de usuario ya existe, elige otro');
            }

            $datos = [
                'nombre'          => $request->nombre,
                'apellidoPaterno' => $request->apellido_paterno,
                'apellidoMaterno' => $request->apellido_materno ?: null,
                'usuario'         => $request->usuario,
                'id_rol'          => $request->id_rol,
            ];

            // Si el campo contraseña se deja vacío, se conserva la actual
            if ($request->filled('password')) {
                $datos['contrasenia'] = Hash::make($request->password);
            }

            DB::connection('mysql')->table('usuarios')->where('id_usu_pk', $id)->update($datos);
        }
        catch (\Exception $e) {
            return back()->withInput()->with('error', 'No se pudo actualizar: ' . $e->getMessage());
        }

        return redirect()->route('usuarios.index')->with('ok', 'El usuario se actualizó con éxito');
    }

    
    public function eliminarusuario($id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        if ((string) $id === (string) session('usuario_id')) {
            return redirect()->route('usuarios.index')->with('error', 'No puedes eliminar al usuario con el que iniciaste sesión');
        }

        try {
            DB::connection('mysql')->table('usuarios')->where('id_usu_pk', $id)->delete();
        }
        catch (\Exception $e) {
            return redirect()->route('usuarios.index')->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }

        return redirect()->route('usuarios.index')->with('ok', 'El usuario se eliminó con éxito');
    }
}