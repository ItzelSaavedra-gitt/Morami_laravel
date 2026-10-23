<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class loginController
{
    // Mostrar el formulario de inicio de sesión
    public function MiInterfaz3()
    {
        return view('login');
    }

    // Conectar con MySQL y validar las credenciales
    public function autenticar(Request $request)
    {
        $request->validate([
            'usuario' => ['required', 'string'],
            'contrasenia' => ['required', 'string'],
        ]);

        try {
            // Buscar el usuario en la base de datos
            $registro = DB::connection('mysql')
                ->table('usuarios')
                ->where('usuario', $request->input('usuario'))
                ->first();

        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('usuario'))
                ->with(
                    'error',
                    'No se pudo conectar con la base de datos.'
                );
        }

        $valida = false;

        if ($registro && isset($registro->contrasenia)) {
            $guardada = (string) $registro->contrasenia;
            $ingresada = (string) $request->input('contrasenia');

            // Comprobar si la contraseña está cifrada
            $esHash = str_starts_with($guardada, '$2y$')
                || str_starts_with($guardada, '$argon2');

            if ($esHash) {
                $valida = Hash::check($ingresada, $guardada);
            } else {
                // Compatibilidad con contraseñas guardadas en texto plano
                $valida = hash_equals($guardada, $ingresada);
            }
        }

        // Usuario o contraseña incorrectos
        if (!$valida) {
            return back()
                ->withInput($request->only('usuario'))
                ->with(
                    'error',
                    'Usuario y contraseña incorrecto'
                );
        }

        // Inicio de sesión correcto
        $request->session()->regenerate();

        Session::put('usuario_id', $registro->id_usu_pk);
        Session::put('usuario_nombre', trim($registro->nombre . ' ' . $registro->apellidoPaterno));

        return redirect('/panel')
            ->with('success', 'Inicio de sesión correcto.');
    }

    // Cerrar sesión
    public function cerrarSesion(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
