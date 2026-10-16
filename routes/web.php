<?php

use App\Http\Controllers\cotizacionController;
use App\Http\Controllers\inventarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\panelController;
use App\Http\Controllers\pantalla_principalController;
use App\Http\Controllers\pedidoController;
use App\Http\Controllers\productosregistradosController;
use App\Http\Controllers\registro_cotizacionesController;
use App\Http\Controllers\registro_pedidosController;
use App\Http\Controllers\registro_productosController;
use App\Http\Controllers\registro_usuController;
use App\Http\Controllers\usuarioController;

Route:: get('/',function(){
    return view('welcome');
});

Route:: get('/usuarios',[usuarioController::class,'MiInterfaz1'])->name('usuarios.index');  //referencia al metodo ::  

Route:: get('/productosre',[productosregistradosController::class,'MiInterfaz7']);

Route:: get('/pedido',[pedidoController::class,'MiInterfaz6']);

Route:: get('/cotizacion',[cotizacionController::class,'MiInterfaz']);  //referencia a metodo ::  


Route:: get('/inventario',[inventarioController::class,'MiInterfaz2']);  //referencia a metodo ::  

Route::get('/login',[loginController::class,'MiInterfaz3'])->name('login');

Route::post('/login',[loginController::class,'Validar'])->name('login.validar');

Route::get('/logout',[loginController::class,'Salir'])->name('login.salir');

Route:: get('/panel',[panelController::class,'MiInterfaz4']);

Route:: get('/pantalla_principal',[pantalla_principalController::class,'MiInterfaz5']);

Route:: get('/registro_cotizaciones',[registro_cotizacionesController::class,'MiInterfaz8']);

Route:: get('/registro_pedidos',[registro_pedidosController::class,'MiInterfaz9']);

Route:: get('/registro_productos',[registro_productosController::class,'MiInterfaz10']);

Route:: get('/registro_usu',[registro_usuController::class,'MiInterfaz11']);

//Rutas para la creacion del CRUD usuarios
Route::prefix('usuarios')->group(function () {
    Route::get('/crear',[usuarioController::class,'vistacrear'])->name('usuarios.vista');
    Route::post('/guardar',[usuarioController::class,'guardarusuario'])->name('usuarios.store');
    Route::get('/buscar',[usuarioController::class,'buscarusuario'])->name('usuarios.search');
    Route::get('/{id}/editar',[usuarioController::class,'vistaeditar'])->name('usuarios.show');
    Route::get('/{id}',[usuarioController::class,'editarusuario'])->name('usuarios.edit');
    Route::put('/{id}',[usuarioController::class,'actualizarusuario'])->name('usuarios.update');
    Route::delete('/{id}',[usuarioController::class,'eliminarusuario'])->name('usuarios.destroy');
});


Route::post('/login', [
    loginController::class, 'autenticar'
])->name('login.autenticar');

// Cerrar sesión
Route::post('/cerrar-sesion', [
    loginController::class, 'cerrarSesion'
])->name('logout');