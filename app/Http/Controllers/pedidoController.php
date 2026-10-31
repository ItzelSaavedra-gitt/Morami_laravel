<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\productosregistradosModel;

class pedidoController extends Controller
{
    private const ESTATUS = ['Pendiente', 'Proceso', 'Completado', 'Entregado'];

    // Estructura de la tabla de productos del pedido (se descubre una sola vez por petición)
    private $detalleCache = false;
    private $cacheColumnas = [];

    private function pedidos()
    {
        return DB::connection('mysql')->table('pedidos');
    }

    private function sinSesion(){
        return !session()->has('usuario_id');
    }


    private function existeTabla(string $tabla): bool
    {
        try {
            return Schema::connection('mysql')->hasTable($tabla);
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function columnasDe(string $tabla): array
    {
        if (!isset($this->cacheColumnas[$tabla])) {
            try {
                $this->cacheColumnas[$tabla] = Schema::connection('mysql')->getColumnListing($tabla);
            } catch (\Throwable $e) {
                $this->cacheColumnas[$tabla] = [];
            }
        }
        return $this->cacheColumnas[$tabla];
    }

    // Primera columna de la tabla que coincide con el patrón (o null)
    private function columnaDe(string $tabla, string $patron)
    {
        foreach ($this->columnasDe($tabla) as $c) {
            if (preg_match($patron, $c)) {
                return $c;
            }
        }
        return null;
    }

    // Tabla y columnas donde se guardan los productos de cada pedido.
    
    private function detalle()
    {
        if ($this->detalleCache !== false) {
            return $this->detalleCache;
        }

        $tabla = null;
        foreach (['detalle_pedido', 'detalle_pedidos'] as $t) {
            if ($this->existeTabla($t)) {
                $tabla = $t;
                break;
            }
        }
        if (!$tabla) {
            return $this->detalleCache = null;
        }

        $m = [
            'tabla'    => $tabla,
            'pedido'   => $this->columnaDe($tabla, '/^id_ped/i'),
            'producto' => $this->columnaDe($tabla, '/^id_pro/i'),
            'cantidad' => $this->columnaDe($tabla, '/cantidad/i'),
            'precio'   => $this->columnaDe($tabla, '/precio/i'),
            'subtotal' => $this->columnaDe($tabla, '/subtotal/i'),
            'nombre'   => $this->columnaDe($tabla, '/^nombreproducto/i'),
            'tipo'     => $this->columnaDe($tabla, '/^tipo/i'),
            'unidad'   => $this->columnaDe($tabla, '/^unidadmedida/i'),
            'color'    => $this->columnaDe($tabla, '/color/i'),
        ];

        return $this->detalleCache = ($m['pedido'] ? $m : null);
    }

    // Rellena las columnas obligatorias.
    
    private function completarObligatorias(string $tabla, array $datos, array $omitir = []): array
    {
        try {
            if (DB::connection('mysql')->getDriverName() !== 'mysql') {
                return $datos;
            }
            foreach (DB::connection('mysql')->select('SHOW COLUMNS FROM `' . str_replace('`', '', $tabla) . '`') as $col) {
                $nombreCol   = $col->Field;
                $extra       = strtolower((string) $col->Extra);
                $obligatoria = ($col->Null === 'NO')
                    && ($col->Default === null)
                    && strpos($extra, 'auto_increment') === false
                    && strpos($extra, 'generated') === false;

                if (!$obligatoria || in_array($nombreCol, $omitir, true) || array_key_exists($nombreCol, $datos)) {
                    continue;
                }

                $tipo = strtolower($col->Type);
                if (preg_match('/int|decimal|numeric|float|double|bit|year/', $tipo)) {
                    $datos[$nombreCol] = 0;
                } elseif (strpos($tipo, 'datetime') === 0 || strpos($tipo, 'timestamp') === 0) {
                    $datos[$nombreCol] = date('Y-m-d H:i:s');
                } elseif (strpos($tipo, 'date') === 0) {
                    $datos[$nombreCol] = date('Y-m-d');
                } elseif (strpos($tipo, 'time') === 0) {
                    $datos[$nombreCol] = '00:00:00';
                } elseif (strpos($tipo, 'enum(') === 0 && preg_match("/enum\('([^']*)'/i", $col->Type, $m)) {
                    $datos[$nombreCol] = $m[1];
                } else {
                    $datos[$nombreCol] = '';
                }
            }
        } catch (\Throwable $e) {
        }
        return $datos;
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
        $q->selectRaw(($conTotal ? $this->expresionTotal() : '0') . ' as total_ped');

        // Campos que las vistas viejas pudieran pedir (vacíos, para no marcar error)
        $q->selectRaw("'' as apellidoP_ped, '' as apellidoM_ped, '' as direccion_ped, '' as municipio_ped, '' as telefono_ped, 0 as fletes_ped");

        return $q;
    }

    // Total del pedido: suma de sus productos, con las columnas reales de la tabla de detalle
    private function expresionTotal(): string
    {
        $d = $this->detalle();
        if (!$d) {
            return '0';
        }

        $t  = '`' . $d['tabla'] . '`';
        $fk = 'd.`' . $d['pedido'] . '`';

        if ($d['subtotal']) {
            return "(SELECT COALESCE(SUM(d.`{$d['subtotal']}`), 0) FROM $t d WHERE $fk = p.id_ped_pk)";
        }
        if ($d['cantidad'] && $d['precio']) {
            return "(SELECT COALESCE(SUM(d.`{$d['cantidad']}` * d.`{$d['precio']}`), 0) FROM $t d WHERE $fk = p.id_ped_pk)";
        }
        return '0';
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

    // Ejecuta la consulta con total; si algo falla, reintenta sin total
    private function obtener(callable $filtro, bool $unico = false)
    {
        try {
            $q = $this->consulta(true);
            $filtro($q);
            return $unico ? $q->first() : $q->get();
        } catch (\Exception $e) {
            Log::warning('pedidoController: la consulta con total falló, se reintenta sin total: ' . $e->getMessage());
            $q = $this->consulta(false);
            $filtro($q);
            return $unico ? $q->first() : $q->get();
        }
    }



    // Detecta las columnas de clientes: nombre, paterno, materno y, si existen, dirección, municipio y teléfono
    private function columnasCliente(): array
    {
        $r = ['nombre' => null, 'paterno' => null, 'materno' => null, 'direccion' => null, 'municipio' => null, 'telefono' => null];
        foreach ($this->columnasDe('clientes') as $col) {
            if (preg_match('/paterno/i', $col)) {
                $r['paterno'] = $r['paterno'] ?? $col;
            } elseif (preg_match('/materno/i', $col)) {
                $r['materno'] = $r['materno'] ?? $col;
            } elseif (preg_match('/^nombre/i', $col)) {
                $r['nombre'] = $r['nombre'] ?? $col;
            } elseif (preg_match('/^direcc/i', $col)) {
                $r['direccion'] = $r['direccion'] ?? $col;
            } elseif (preg_match('/^municip/i', $col)) {
                $r['municipio'] = $r['municipio'] ?? $col;
            } elseif (preg_match('/^(tel|phone|celular)/i', $col)) {
                $r['telefono'] = $r['telefono'] ?? $col;
            }
        }
        return $r;
    }

    // Busca al cliente por nombre completo; si no existe lo crea. Devuelve su id_cli_pk
    private function buscarOCrearCliente(Request $request)
    {
        if (!$this->existeTabla('clientes')) {
            throw new \Exception("No existe la tabla 'clientes'.");
        }

        $nombre  = trim((string) $request->input('nombre_cliente'));
        $paterno = trim((string) $request->input('apellidoP'));
        $materno = trim((string) $request->input('apellidoM'));

        $cols = $this->columnasCliente();
        if (!$cols['nombre']) {
            throw new \Exception("No se encontró la columna del nombre en la tabla 'clientes'.");
        }

        $q = DB::connection('mysql')->table('clientes')->where($cols['nombre'], $nombre);
        if ($cols['paterno']) {
            $q->where($cols['paterno'], $paterno);
        }
        if ($cols['materno']) {
            $c = $cols['materno'];
            if ($materno === '') {
                $q->where(function ($w) use ($c) {
                    $w->whereNull($c)->orWhere($c, '');
                });
            } else {
                $q->where($c, $materno);
            }
        }

        $id = $q->value('id_cli_pk');
        if ($id) {
            return $id;
        }

        $datos = [$cols['nombre'] => $nombre];
        if ($cols['paterno']) { $datos[$cols['paterno']] = $paterno; }
        if ($cols['materno']) { $datos[$cols['materno']] = ($materno === '') ? null : $materno; }

        // Dirección, municipio y teléfono se guardan en el cliente solo si la tabla tiene esas columnas
        foreach (['direccion' => 'direccion', 'municipio' => 'municipio', 'telefono' => 'tel'] as $clave => $campo) {
            $valor = trim((string) $request->input($campo));
            if ($cols[$clave] && $valor !== '') {
                $datos[$cols[$clave]] = $valor;
            }
        }

        $datos = $this->completarObligatorias('clientes', $datos, ['id_cli_pk']);

        return DB::connection('mysql')->table('clientes')->insertGetId($datos, 'id_cli_pk');
    }


    private function largoColumnaCliente(string $clave, int $defecto): int
    {
        try {
            $col = $this->columnasCliente()[$clave] ?? null;
            if (!$col) {
                return $defecto;
            }
            foreach (DB::connection('mysql')->select('SHOW COLUMNS FROM `clientes`') as $c) {
                if ($c->Field === $col && preg_match('/^(?:var)?char\((\d+)\)/i', $c->Type, $m)) {
                    return min($defecto, (int) $m[1]);
                }
            }
        } catch (\Throwable $e) {
        }
        return $defecto;
    }

    // Datos del cliente de un pedido (para llenar el formulario al editar y el detalle)
    private function datosCliente($idCliente): array
    {
        $vacio = ['nombre' => '', 'paterno' => '', 'materno' => '', 'direccion' => '', 'municipio' => '', 'telefono' => ''];

        if (!$idCliente || !$this->existeTabla('clientes')) {
            return $vacio;
        }

        $fila = DB::connection('mysql')->table('clientes')->where('id_cli_pk', $idCliente)->first();
        if (!$fila) {
            return $vacio;
        }

        $cols = $this->columnasCliente();
        foreach ($vacio as $clave => $_) {
            $vacio[$clave] = $cols[$clave] ? (string) ($fila->{$cols[$clave]} ?? '') : '';
        }
        return $vacio;
    }


    // Catálogo de productos activos para sugerir y autocompletar en el formulario
    private function catalogo(){
        try {
            return productosregistradosModel::select('id_pro_pk', 'nombre_pro', 'color_pro', 'tipo_pro', 'unidadMedida', 'precioUnitario_pro', 'CantidadPiezas_pro')
                ->where('estado_pro', '1')
                ->orderBy('nombre_pro')
                ->get();
        } catch (\Throwable $e) {
            return [];
        }
    }

    // Devuelve el id_pro_pk del producto registrado que corresponde a una fila del formulario
    private function resolverProducto(array $p)
    {
        // Si el formulario ya trae el id (producto elegido de la lista), se valida y se usa
        if (!empty($p['id_pro']) && is_numeric($p['id_pro'])) {
            $existe = productosregistradosModel::where('id_pro_pk', (int) $p['id_pro'])->value('id_pro_pk');
            if ($existe) {
                return $existe;
            }
        }

        // Si no, se busca por nombre (y tipo / unidad / color si se indicaron)
        $q = productosregistradosModel::where('estado_pro', '1')->where('nombre_pro', $p['nombre']);
        if (!empty($p['material'])) { $q->where('tipo_pro', $p['material']); }
        if (!empty($p['medida']))   { $q->where('unidadMedida', $p['medida']); }
        if (!empty($p['color']))    { $q->where('color_pro', $p['color']); }

        $id = $q->orderBy('id_pro_pk')->value('id_pro_pk');

        // Último intento: solo por nombre
        if (!$id) {
            $id = productosregistradosModel::where('estado_pro', '1')->where('nombre_pro', $p['nombre'])->orderBy('id_pro_pk')->value('id_pro_pk');
        }
        if (!$id) {
            throw new \Exception("El producto '{$p['nombre']}' no está registrado. Regístralo primero en Productos registrados o elígelo de la lista sugerida.");
        }
        return $id;
    }

    // Arma las filas de la tabla de detalle usando solo las columnas que existen
    private function filasDetalle(Request $request, $idPedido){
        $d = $this->detalle();
        if (!$d) {
            throw new \Exception("No existe la tabla de productos del pedido (detalle_pedido o detalle_pedidos).");
        }

        $filas = [];
        foreach ($request->productos as $p) {
            $fila = [$d['pedido'] => $idPedido];

            if ($d['producto']) { $fila[$d['producto']] = $this->resolverProducto($p); }
            if ($d['nombre'])   { $fila[$d['nombre']]   = $p['nombre']; }
            if ($d['tipo'])     { $fila[$d['tipo']]     = $p['material']; }
            if ($d['unidad'])   { $fila[$d['unidad']]   = $p['medida']; }
            if ($d['color'] && !empty($p['color'])) { $fila[$d['color']] = $p['color']; }

            if ($d['cantidad']) { $fila[$d['cantidad']] = $p['cantidad']; }
            if ($d['precio'])   { $fila[$d['precio']]   = $p['precio']; }
            if ($d['subtotal']) { $fila[$d['subtotal']] = round($p['cantidad'] * $p['precio'], 2); }

            $filas[] = $this->completarObligatorias($d['tabla'], $fila);
        }
        return $filas;
    }

    // Productos de un pedido, con nombres de campo uniformes sin importar cómo esté armada la tabla
    private function detallesDe($id)
    {
        $d = $this->detalle();
        if (!$d) {
            return collect();
        }

        $filas = DB::connection('mysql')->table($d['tabla'])->where($d['pedido'], $id)->get();

        $prods = collect();
        if ($d['producto']) {
            $ids = $filas->pluck($d['producto'])->filter()->unique()->all();
            if ($ids) {
                $prods = productosregistradosModel::whereIn('id_pro_pk', $ids)->get()->keyBy('id_pro_pk');
            }
        }

        return $filas->map(function ($r) use ($d, $prods) {
            $p        = $d['producto'] ? $prods->get($r->{$d['producto']}) : null;
            $cantidad = $d['cantidad'] ? ($r->{$d['cantidad']} ?? 0) : 0;
            $precio   = $d['precio']   ? ($r->{$d['precio']}   ?? 0) : ($p->precioUnitario_pro ?? 0);

            return (object) [
                'id_pro'             => $d['producto'] ? ($r->{$d['producto']} ?? null) : null,
                'nombreProducto_det' => $d['nombre'] ? ($r->{$d['nombre']} ?? '') : ($p->nombre_pro ?? ''),
                'tipo_det'           => $d['tipo']   ? ($r->{$d['tipo']}   ?? '') : ($p->tipo_pro ?? ''),
                'unidadMedida_det'   => $d['unidad'] ? ($r->{$d['unidad']} ?? '') : ($p->unidadMedida ?? ''),
                'color_det'          => $d['color']  ? ($r->{$d['color']}  ?? '') : ($p->color_pro ?? ''),
                'cantidad_det'       => $cantidad,
                'precioUnitario_det' => $precio,
                'subtotal_det'       => $d['subtotal'] ? ($r->{$d['subtotal']} ?? $cantidad * $precio) : $cantidad * $precio,
            ];
        });
    }



    private function reglas(bool $conEstatus): array
    {
        $r = [
            'nombre_cliente'       => 'required|string|max:' . $this->largoColumnaCliente('nombre', 100),
            'apellidoP'            => 'required|string|max:' . $this->largoColumnaCliente('paterno', 100),
            'apellidoM'            => 'nullable|string|max:' . $this->largoColumnaCliente('materno', 100),
            'direccion'            => 'nullable|string|max:' . $this->largoColumnaCliente('direccion', 200),
            'municipio'            => 'nullable|string|max:' . $this->largoColumnaCliente('municipio', 100),
            'tel'                  => 'nullable|string|max:' . $this->largoColumnaCliente('telefono', 20),
            'fecha'                => 'required|date_format:d/m/Y,Y-m-d',
            'fecha_entrega'        => 'nullable|date_format:d/m/Y,Y-m-d',
            'productos'            => 'required|array|min:1',
            'productos.*.id_pro'   => 'nullable|integer',
            'productos.*.nombre'   => 'required|string|max:100',
            'productos.*.material' => 'required|string|max:50',
            'productos.*.medida'   => 'required|string|max:20',
            'productos.*.color'    => 'nullable|string|max:50',
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
            'nombre_cliente.required' => 'Ingresa el nombre del cliente',
            'apellidoP.required'      => 'Ingresa el apellido paterno',
            'nombre_cliente.max'      => 'El nombre no puede tener más de :max caracteres',
            'apellidoP.max'           => 'El apellido paterno no puede tener más de :max caracteres',
            'apellidoM.max'           => 'El apellido materno no puede tener más de :max caracteres',
            'direccion.max'           => 'La dirección no puede tener más de :max caracteres',
            'municipio.max'           => 'El municipio no puede tener más de :max caracteres',
            'tel.max'                 => 'El teléfono no puede tener más de :max caracteres',
            'fecha.required'          => 'Selecciona la fecha de solicitud',
            'fecha.date_format'       => 'La fecha debe tener el formato día/mes/año',
            'productos.required'      => 'Agrega al menos un producto al pedido',
            'productos.min'           => 'Agrega al menos un producto al pedido',
        ];
    }

    private function fechaSql($valor)
    {
        if (!$valor) {
            return null;
        }
        $f = \DateTime::createFromFormat('d/m/Y', $valor) ?: \DateTime::createFromFormat('Y-m-d', $valor);
        return $f ? $f->format('Y-m-d') : null;
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
        $cliente = ['nombre' => '', 'paterno' => '', 'materno' => '', 'direccion' => '', 'municipio' => '', 'telefono' => ''];
        $detalles = [];
        $catalogo = $this->catalogo();
        return view("registro_pedidos", compact('pedido', 'cliente', 'detalles', 'catalogo'));
    }

    public function guardarpedido(Request $request){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        $request->validate($this->reglas(false), $this->mensajes());

        try {
            DB::connection('mysql')->transaction(function () use ($request) {
                $datos = [
                    'fecha_ped'   => $this->fechaSql($request->fecha),
                    'estatus_ped' => 'Pendiente',
                    'id_cli_pk'   => $this->buscarOCrearCliente($request),
                    'id_usu_pk'   => session('usuario_id'),     // el vendedor es quien tiene la sesión
                ];
                if ($this->fechaSql($request->fecha_entrega)) {
                    $datos['fechaEntrega_ped'] = $this->fechaSql($request->fecha_entrega);
                }
                $datos = $this->completarObligatorias('pedidos', $datos, ['id_ped_pk']);

                $idPedido = $this->pedidos()->insertGetId($datos, 'id_ped_pk');

                $filas = $this->filasDetalle($request, $idPedido);
                DB::connection('mysql')->table($this->detalle()['tabla'])->insert($filas);
            });
        }
        catch (\Exception $e) {
            Log::error('pedidoController@guardarpedido: ' . $e->getMessage());
            return back()->withInput()->with('error', 'No se pudo guardar: ' . $e->getMessage());
        }

        return redirect()->route('pedidos.index')->with('ok', 'El pedido se registró con éxito');
    }


    // =====================================================================
    //  EDITAR
    // =====================================================================

    public function vistaeditarpedido($id){
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        try {
            $pedido = $this->obtener(function ($q) use ($id) { $q->where('p.id_ped_pk', $id); }, true);
            if ($pedido) {
                $cliente  = $this->datosCliente($pedido->id_cli_pk);
                $detalles = $this->detallesDe($id);
            }
        }
        catch (\Exception $e) {
            return response("Error al consultar la base de datos: " . $e->getMessage(), 500);
        }

        if (!$pedido) {
            return redirect()->route('pedidos.index')->with('error', 'El pedido no existe');
        }

        $catalogo = $this->catalogo();
        return view("registro_pedidos", compact('pedido', 'cliente', 'detalles', 'catalogo'));
    }

    // Datos del pedido, de su cliente y de sus productos en JSON (para "Mostrar detalles")
    public function editarpedido($id){
        if ($this->sinSesion()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $pedido = $this->obtener(function ($q) use ($id) { $q->where('p.id_ped_pk', $id); }, true);

        if (!$pedido) {
            return response()->json(['error' => 'El pedido no existe'], 404);
        }

        return response()->json([
            'pedido'   => $pedido,
            'cliente'  => $this->datosCliente($pedido->id_cli_pk),
            'detalles' => $this->detallesDe($id),
        ]);
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
                if (in_array($request->estatus, ['Completado', 'Entregado'], true) && !$fechaEntrega) {
                    $fechaEntrega = date('Y-m-d');
                }

                $this->pedidos()->where('id_ped_pk', $id)->update([
                    'fecha_ped'        => $this->fechaSql($request->fecha),
                    'fechaEntrega_ped' => $fechaEntrega,
                    'estatus_ped'      => $request->estatus,
                    'id_cli_pk'        => $this->buscarOCrearCliente($request),
                ]);

                // Se reemplazan los productos del pedido por los del formulario
                $d = $this->detalle();
                if ($d) {
                    DB::connection('mysql')->table($d['tabla'])->where($d['pedido'], $id)->delete();
                }
                $filas = $this->filasDetalle($request, $id);
                DB::connection('mysql')->table($this->detalle()['tabla'])->insert($filas);
            });
        }
        catch (\Exception $e) {
            Log::error('pedidoController@actualizarpedido: ' . $e->getMessage());
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
                $d = $this->detalle();
                if ($d) {
                    DB::connection('mysql')->table($d['tabla'])->where($d['pedido'], $id)->delete();
                }
                $this->pedidos()->where('id_ped_pk', $id)->delete();
            });
        }
        catch (\Exception $e) {
            return redirect()->route('pedidos.index')->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }

        return redirect()->route('pedidos.index')->with('ok', 'El pedido se eliminó con éxito');
    }
}