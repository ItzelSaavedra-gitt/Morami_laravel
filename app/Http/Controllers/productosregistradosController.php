<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\productosregistradosModel;
 
class productosregistradosController extends Controller
{
    private $columnas = ['id_pro_pk', 'nombre_pro', 'color_pro', 'tipo_pro', 'formato_pro', 'CantidadPiezas_pro', 'unidadMedida', 'fechaCaducidad', 'precioUnitario_pro', 'estado_pro'];
 
    // Verifica que haya sesión iniciada; si no, manda al login
    private function sinSesion(){
        return !session()->has('usuario_id');
    }
 
 
    public function MiInterfaz7(){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
 
        try {
            $resProducto = productosregistradosModel::select($this->columnas)
                ->where('estado_pro', '1')
                ->orderBy('id_pro_pk', 'desc')
                ->get();
 
            $titulo="Grupo Morami";
            $descontinuados = false;
            return view("productosregistrados", compact('titulo', 'resProducto', 'descontinuados'));
        }
        catch(\Exception $e){
            return response("Error al consultar la base de datos: ".$e->getMessage(), 500);
        }
    }
 
 
    public function verdescontinuados(){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
 
        try {
            $resProducto = productosregistradosModel::select($this->columnas)
                ->where('estado_pro', '0')
                ->orderBy('id_pro_pk', 'desc')
                ->get();
 
            $titulo="Grupo Morami";
            $descontinuados = true;
            return view("productosregistrados", compact('titulo', 'resProducto', 'descontinuados'));
        }
        catch(\Exception $e){
            return response("Error al consultar la base de datos: ".$e->getMessage(), 500);
        }
    }
 
 
    
    public function generarpdf(){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
 
        try {
            $resProducto = productosregistradosModel::select($this->columnas)
                ->where('estado_pro', '1')
                ->orderBy('nombre_pro')
                ->get();
 
            return view("productos_pdf", compact('resProducto'));
        }
        catch(\Exception $e){
            return response("Error al consultar la base de datos: ".$e->getMessage(), 500);
        }
    }
 
 
    
    public function buscarproducto(Request $request){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
 
        $q = trim((string) $request->input('q'));
 
        try {
            $consulta = productosregistradosModel::select($this->columnas)->where('estado_pro', '1');
 
            if ($q !== '') {
                $consulta->where(function ($w) use ($q) {
                    $w->where('nombre_pro', 'like', "%{$q}%")
                      ->orWhere('color_pro', 'like', "%{$q}%")
                      ->orWhere('tipo_pro', 'like', "%{$q}%")
                      ->orWhere('unidadMedida', 'like', "%{$q}%");
                });
            }
 
            $resProducto = $consulta->orderBy('id_pro_pk', 'desc')->get();
            $titulo="Grupo Morami";
            $busqueda = $q;
            $descontinuados = false;
            return view("productosregistrados", compact('titulo', 'resProducto', 'busqueda', 'descontinuados'));
        }
        catch(\Exception $e){
            return response("Error al consultar la base de datos: ".$e->getMessage(), 500);
        }
    }
 
 
    
    public function vistacrearproducto(){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
        $producto = null;
        return view("registro_productos", compact('producto'));
    }
 
 
    
    public function guardarproducto(Request $request){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
 
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'material'  => 'required|string|max:50',
            'medida'    => 'required|in:Caja,Bulto,Pieza',
            'colores'   => 'nullable|string|max:50',
            'cantidad'  => 'required|integer|min:1|max:1000',
            'formato'   => 'required|string|max:20',
            'caducidad' => 'nullable|required_if:medida,Bulto|date_format:d/m/Y',
            'precio'    => 'required|numeric|min:0',
        ]);
 
        try {
            $existe = productosregistradosModel::where('nombre_pro', $request->nombre)
                ->where('color_pro', $request->colores ?: null)
                ->where('tipo_pro', $request->material)
                ->where('formato_pro', $request->formato)
                ->exists();
 
            if ($existe) {
                return back()->withInput()->with('error', 'Ese producto ya está registrado con el mismo tipo, color y formato');
            }
 
            productosregistradosModel::insert([
                'nombre_pro'         => $request->nombre,
                'tipo_pro'           => $request->material,
                'unidadMedida'       => $request->medida,
                'color_pro'          => $request->colores ?: null,
                'CantidadPiezas_pro' => $request->cantidad,
                'formato_pro'        => $request->formato,
                'fechaCaducidad'     => ($request->medida === 'Bulto' && $request->caducidad)
                                            ? \DateTime::createFromFormat('d/m/Y', $request->caducidad)->format('Y-m-d')
                                            : null,
                'precioUnitario_pro' => $request->precio,
                'estado_pro'         => '1',   // 1 = activo, 0 = descontinuado
            ]);
        }
        catch (\Exception $e) {
            return back()->withInput()->with('error', 'No se pudo guardar: ' . $e->getMessage());
        }
 
        return redirect()->route('productos.index')->with('ok', 'El producto se registró con éxito');
    }
 
 
   
    public function vistaeditarproducto($id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
 
        try {
            $producto = productosregistradosModel::select($this->columnas)
                ->where('id_pro_pk', $id)->first();
        }
        catch (\Exception $e) {
            return response("Error al consultar la base de datos: ".$e->getMessage(), 500);
        }
 
        if (!$producto) {
            return redirect()->route('productos.index')->with('error', 'El producto no existe');
        }
 
        return view("registro_productos", compact('producto'));
    }
 
 
    
    public function editarproducto($id){
        if ($this->sinSesion()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }
 
        $producto = productosregistradosModel::select($this->columnas)
            ->where('id_pro_pk', $id)->first();
 
        if (!$producto) {
            return response()->json(['error' => 'El producto no existe'], 404);
        }
        return response()->json($producto);
    }
 
 
    
    public function actualizarproducto(Request $request, $id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
 
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'material'  => 'required|string|max:50',
            'medida'    => 'required|in:Caja,Bulto,Pieza',
            'colores'   => 'nullable|string|max:50',
            'cantidad'  => 'required|integer|min:1|max:1000',
            'formato'   => 'required|string|max:20',
            'caducidad' => 'nullable|required_if:medida,Bulto|date_format:d/m/Y',
            'precio'    => 'required|numeric|min:0',
        ]);
 
        try {
            $repetido = productosregistradosModel::where('nombre_pro', $request->nombre)
                ->where('color_pro', $request->colores ?: null)
                ->where('tipo_pro', $request->material)
                ->where('formato_pro', $request->formato)
                ->where('id_pro_pk', '<>', $id)->exists();
 
            if ($repetido) {
                return back()->withInput()->with('error', 'Ya existe otro producto con el mismo nombre, tipo, color y formato');
            }
 
            $datos = [
                'nombre_pro'         => $request->nombre,
                'tipo_pro'           => $request->material,
                'unidadMedida'       => $request->medida,
                'color_pro'          => $request->colores ?: null,
                'CantidadPiezas_pro' => $request->cantidad,
                'formato_pro'        => $request->formato,
                'fechaCaducidad'     => ($request->medida === 'Bulto' && $request->caducidad)
                                            ? \DateTime::createFromFormat('d/m/Y', $request->caducidad)->format('Y-m-d')
                                            : null,
                'precioUnitario_pro' => $request->precio,
            ];
 
            productosregistradosModel::where('id_pro_pk', $id)->update($datos);
        }
        catch (\Exception $e) {
            return back()->withInput()->with('error', 'No se pudo actualizar: ' . $e->getMessage());
        }
 
        return redirect()->route('productos.index')->with('ok', 'El producto se actualizó con éxito');
    }
 
 
    
    public function eliminarproducto($id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
 
        try {
            productosregistradosModel::where('id_pro_pk', $id)->update(['estado_pro' => '0']);
        }
        catch (\Exception $e) {
            return redirect()->route('productos.index')->with('error', 'No se pudo descontinuar: ' . $e->getMessage());
        }
 
        return redirect()->route('productos.index')->with('ok', 'El producto se envió a descontinuados');
    }
 
 
   
    public function reactivarproducto($id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
 
        try {
            productosregistradosModel::where('id_pro_pk', $id)->update(['estado_pro' => '1']);
        }
        catch (\Exception $e) {
            return redirect()->route('productos.descontinuados')->with('error', 'No se pudo reactivar: ' . $e->getMessage());
        }
 
        return redirect()->route('productos.descontinuados')->with('ok', 'El producto se reactivó con éxito');
    }
}
 