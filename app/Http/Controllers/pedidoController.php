<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class pedidoController extends Controller
{
    private const ESTATUS = ['Pendiente', 'Proceso', 'Completado'];

    private function pedidos()
    {
        return DB::connection('mysql')->table('pedidos');
    }

    private function sinSesion(){
        return !session()->has('usuario_id');
    }

    
    private function consulta(bool $conTotal = true)
    {
        $q = DB::connection('mysql')->table('pedidos as p');

        $hayClientes = $this->existeTabla('clientes');
        if ($hayClientes) {
            $q->leftJoin('clientes as c', 'c.id_cli_pk', '=', 'p.id_cli_pk');
        }
        $q->leftJoin('usuarios as u', 'u.id_usu_pk', '=', 'p.id_usu_pk');

        $q->select('p.id_ped_pk', 'p.fecha_ped', 'p.fechaEntrega_ped', 'p.estatus_ped', 'p.id_cli_pk', 'p.id_usu_pk');
        $q->selectRaw($this->expresionCliente($hayClientes) . ' as nombreCliente_ped');
        $q->selectRaw("TRIM(CONCAT_WS(' ', u.nombre, u.apellidoPaterno, u.apellidoMaterno)) as vendedor_ped");
        $q->selectRaw($conTotal
            ? '(SELECT COALESCE(SUM(d.subtotal_det), 0) FROM detalle_pedidos d WHERE d.id_ped_fk = p.id_ped_pk) as total_ped'
            : '0 as total_ped');

        // Campos que las vistas viejas pudieran pedir (vacíos, para no marcar error)
        $q->selectRaw("'' as apellidoP_ped, '' as apellidoM_ped, '' as direccion_ped, '' as municipio_ped, '' as telefono_ped, 0 as fletes_ped");

        return $q;
    }

    // Nombre completo del cliente a partir de las columnas nombre*/apellido* de clientes
    private function expresionCliente(bool $hayClientes): string
    {
        if ($hayClientes) {
            try {
                $partes = [];
                foreach (Schema::connection('mysql')->getColumnListing('clientes') as $col) {
                    if (preg_match('/^(nombre|apellido)/i', $col)) {
                        $partes[] = 'c.`' . str_replace('`', '', $col) . '`';
                    }
                }
                if ($partes) {
                    return "TRIM(CONCAT_WS(' ', " . implode(', ', $partes) . "))";
                }
            } catch (\Throwable $e) {
            }
        }
        return "CONCAT('Cliente ', p.id_cli_pk)";
    }

    private function existeTabla(string $tabla): bool
    {
        try {
            return Schema::connection('mysql')->hasTable($tabla);
        } catch (\Throwable $e) {
            return false;
        }
    }

    // Ejecuta la consulta con total; si detalle_pedidos tiene otras columnas, reintenta sin total
    private function obtener(callable $filtro, bool $unico = false)
    {
        try {
            $q = $this->consulta(true);
            $filtro($q);
            return $unico ? $q->first() : $q->get();
        } catch (\Exception $e) {
            $q = $this->consulta(false);
            $filtro($q);
            return $unico ? $q->first() : $q->get();
        }
    }

    private function catalogo(){
        try {
            return DB::connection('mysql')->table('productos')
                ->select('nombre_pro', 'tipo_pro', 'unidadMedida', 'precioUnitario_pro')
                ->orderBy('nombre_pro')->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    private function reglas(bool $conEstatus): array
    {
        $r = [
            'fecha'                => 'required|date_format:d/m/Y',
            'fecha_entrega'        => 'nullable|date_format:d/m/Y',
            'id_cli_pk'            => 'nullable|integer|min:1',
            'productos'            => 'required|array|min:1',
            'productos.*.nombre'   => 'required|string|max:100',
            'productos.*.material' => 'required|string|max:50',
            'productos.*.medida'   => 'required|string|max:20',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio'   => 'required|numeric|min:0',
        ];
        if ($conEstatus) {
            $r['estatus'] = 'required|in:' . implode(',', self::ESTATUS);
        }
        return $r;
    }

    private function mensajes(): array
    {
        return [
            'productos.required' => 'Agrega al menos un producto al pedido',
            'productos.min'      => 'Agrega al menos un producto al pedido',
        ];
    }

    private function fechaSql($valor)
    {
        if (!$valor) {
            return null;
        }
        return \DateTime::createFromFormat('d/m/Y', $valor)->format('Y-m-d');
    }

    private function filasDetalle(Request $request, $idPedido){
        $filas = [];
        foreach ($request->productos as $p) {
            $filas[] = [
                'id_ped_fk'          => $idPedido,
                'nombreProducto_det' => $p['nombre'],
                'tipo_det'           => $p['material'],
                'unidadMedida_det'   => $p['medida'],
                'cantidad_det'       => $p['cantidad'],
                'precioUnitario_det' => $p['precio'],
                'subtotal_det'       => $p['cantidad'] * $p['precio'],
            ];
        }
        return $filas;
    }

    
    public function MiInterfaz6(){
        return $this->listar('', '');
    }

    public function buscarpedido(Request $request){
        return $this->listar(trim((string) $request->input('fecha')), trim((string) $request->input('estatus')));
    }

    private function listar(string $filtroFecha, string $filtroEstatus){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        try {
            $resPedido = $this->obtener(function ($q) use ($filtroFecha, $filtroEstatus) {
                if ($filtroFecha !== '')   { $q->where('p.fecha_ped', $filtroFecha); }
                if ($filtroEstatus !== '') { $q->where('p.estatus_ped', $filtroEstatus); }
                $q->orderBy('p.id_ped_pk', 'desc');
            });

            $fechas = $this->pedidos()->distinct()->orderBy('fecha_ped', 'desc')->pluck('fecha_ped');
            $titulo = "Grupo Morami";

            return view("pedido", compact('titulo', 'resPedido', 'fechas', 'filtroFecha', 'filtroEstatus'));
        }
        catch (\Exception $e) {
            return response("Error al consultar la base de datos: " . $e->getMessage(), 500);
        }
    }

    
    public function vistacrearpedido(){
        if ($this->sinSesion()) {
            return redirect('/login');
        }
        $pedido = null;
        $detalles = [];
        $catalogo = $this->catalogo();
        return view("registro_pedidos", compact('pedido', 'detalles', 'catalogo'));
    }

    public function guardarpedido(Request $request){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        $request->validate($this->reglas(false), $this->mensajes());

        try {
            DB::connection('mysql')->transaction(function () use ($request) {
                $idPedido = $this->pedidos()->insertGetId([
                    'fecha_ped'        => $this->fechaSql($request->fecha),
                    'fechaEntrega_ped' => $this->fechaSql($request->fecha_entrega),
                    'estatus_ped'      => 'Pendiente',
                    'id_cli_pk'        => $request->input('id_cli_pk', 1),
                    'id_usu_pk'        => session('usuario_id'),
                ]);

                DB::connection('mysql')->table('detalle_pedidos')->insert($this->filasDetalle($request, $idPedido));
            });
        }
        catch (\Exception $e) {
            return back()->withInput()->with('error', 'No se pudo guardar: ' . $e->getMessage());
        }

        return redirect()->route('pedidos.index')->with('ok', 'El pedido se registró con éxito');
    }

   
    public function vistaeditarpedido($id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        try {
            $pedido = $this->obtener(function ($q) use ($id) { $q->where('p.id_ped_pk', $id); }, true);
            $detalles = DB::connection('mysql')->table('detalle_pedidos')->where('id_ped_fk', $id)->get();
        }
        catch (\Exception $e) {
            return response("Error al consultar la base de datos: " . $e->getMessage(), 500);
        }

        if (!$pedido) {
            return redirect()->route('pedidos.index')->with('error', 'El pedido no existe');
        }

        $catalogo = $this->catalogo();
        return view("registro_pedidos", compact('pedido', 'detalles', 'catalogo'));
    }

    public function editarpedido($id){
        if ($this->sinSesion()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $pedido = $this->obtener(function ($q) use ($id) { $q->where('p.id_ped_pk', $id); }, true);

        if (!$pedido) {
            return response()->json(['error' => 'El pedido no existe'], 404);
        }

        $detalles = DB::connection('mysql')->table('detalle_pedidos')->where('id_ped_fk', $id)->get();

        return response()->json(['pedido' => $pedido, 'detalles' => $detalles]);
    }

    
    public function actualizarpedido(Request $request, $id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        $request->validate($this->reglas(true), $this->mensajes());

        try {
            $actual = $this->pedidos()->select('id_ped_pk', 'fechaEntrega_ped')->where('id_ped_pk', $id)->first();

            if (!$actual) {
                return redirect()->route('pedidos.index')->with('error', 'El pedido no existe');
            }

            DB::connection('mysql')->transaction(function () use ($request, $id, $actual) {
                $fechaEntrega = $this->fechaSql($request->fecha_entrega) ?: $actual->fechaEntrega_ped;
                if ($request->estatus === 'Completado' && !$fechaEntrega) {
                    $fechaEntrega = date('Y-m-d');
                }

                $datos = [
                    'fecha_ped'        => $this->fechaSql($request->fecha),
                    'fechaEntrega_ped' => $fechaEntrega,
                    'estatus_ped'      => $request->estatus,
                ];
                if ($request->filled('id_cli_pk')) {
                    $datos['id_cli_pk'] = $request->id_cli_pk;
                }
                $this->pedidos()->where('id_ped_pk', $id)->update($datos);

                DB::connection('mysql')->table('detalle_pedidos')->where('id_ped_fk', $id)->delete();
                DB::connection('mysql')->table('detalle_pedidos')->insert($this->filasDetalle($request, $id));
            });
        }
        catch (\Exception $e) {
            return back()->withInput()->with('error', 'No se pudo actualizar: ' . $e->getMessage());
        }

        return redirect()->route('pedidos.index')->with('ok', 'El pedido se actualizó con éxito');
    }

    
    public function eliminarpedido($id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        try {
            DB::connection('mysql')->transaction(function () use ($id) {
                DB::connection('mysql')->table('detalle_pedidos')->where('id_ped_fk', $id)->delete();
                $this->pedidos()->where('id_ped_pk', $id)->delete();
            });
        }
        catch (\Exception $e) {
            return redirect()->route('pedidos.index')->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }

        return redirect()->route('pedidos.index')->with('ok', 'El pedido se eliminó con éxito');
    }
}