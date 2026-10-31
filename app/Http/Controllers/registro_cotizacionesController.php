<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\cotizacionModel;
use App\Models\productosregistradosModel;

class registro_cotizacionesController
{
    // Tabla donde se guardan los productos de cada cotización.
    private $tablaDetalle = 'detalle_cotizacion';
    private $colDetalle = [
        'cotizacion' => 'id_cot_pk',
        'producto'   => 'id_pro_pk',
        'cantidad'   => 'cantidadProductos_dcot',
        'precio'     => 'precioUnitario_dcot',
        'subtotal'   => 'subtotal_dcot',
    ];

    // Días de vigencia que se suman a la fecha de solicitud
    private $diasVigencia = 10;


    private function sinSesion()
    {
        return !session()->has('usuario_id');
    }


    // Detecta las columnas nombre / apellido paterno / apellido materno de clientes
    private function columnasCliente()
    {
        $r = ['nombre' => null, 'paterno' => null, 'materno' => null];
        foreach (Schema::connection('mysql')->getColumnListing('clientes') as $col) {
            if (preg_match('/paterno/i', $col)) {
                $r['paterno'] = $r['paterno'] ?? $col;
            } elseif (preg_match('/materno/i', $col)) {
                $r['materno'] = $r['materno'] ?? $col;
            } elseif (preg_match('/^nombre/i', $col)) {
                $r['nombre'] = $r['nombre'] ?? $col;
            }
        }
        return $r;
    }

    // Busca al cliente por nombre completo; si no existe lo crea. Regresa su id.
    private function buscarOCrearCliente($nombre, $paterno, $materno)
    {
        if (!Schema::connection('mysql')->hasTable('clientes')) {
            throw new \Exception("No existe la tabla 'clientes'.");
        }

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
        if ($cols['paterno']) {
            $datos[$cols['paterno']] = $paterno;
        }
        if ($cols['materno']) {
            $datos[$cols['materno']] = ($materno === '') ? null : $materno;
        }

        // Rellena las columnas obligatorias sin valor por defecto (teléfono, correo, etc.)
        // que este formulario no captura, para que el INSERT no falle.
        foreach (DB::connection('mysql')->select('SHOW COLUMNS FROM `clientes`') as $col) {
            $nombreCol   = $col->Field;
            $extra       = strtolower((string) $col->Extra);
            $obligatoria = ($col->Null === 'NO')
                && ($col->Default === null)
                && strpos($extra, 'auto_increment') === false
                && strpos($extra, 'generated') === false;

            if (!$obligatoria || $nombreCol === 'id_cli_pk' || array_key_exists($nombreCol, $datos)) {
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

        return DB::connection('mysql')->table('clientes')->insertGetId($datos, 'id_cli_pk');
    }

    // Nombre, apellido paterno y materno de un cliente (para llenar el formulario al editar)
    private function datosCliente($idCliente)
    {
        $vacio = ['nombre' => '', 'paterno' => '', 'materno' => ''];

        if (!$idCliente || !Schema::connection('mysql')->hasTable('clientes')) {
            return $vacio;
        }

        $cols = $this->columnasCliente();
        $fila = DB::connection('mysql')->table('clientes')->where('id_cli_pk', $idCliente)->first();
        if (!$fila) {
            return $vacio;
        }

        return [
            'nombre'  => $cols['nombre']  ? ($fila->{$cols['nombre']}  ?? '') : '',
            'paterno' => $cols['paterno'] ? ($fila->{$cols['paterno']} ?? '') : '',
            'materno' => $cols['materno'] ? ($fila->{$cols['materno']} ?? '') : '',
        ];
    }


    // Catálogo de productos activos (para sugerir y autocompletar en el formulario)
    private function catalogoProductos()
    {
        try {
            return productosregistradosModel::select('id_pro_pk', 'nombre_pro', 'color_pro', 'tipo_pro', 'formato_pro', 'unidadMedida', 'precioUnitario_pro')
                ->where('estado_pro', '1')
                ->orderBy('nombre_pro')
                ->get()
                ->map(function ($p) {
                    return [
                        'id'      => $p->id_pro_pk,
                        'nombre'  => $p->nombre_pro,
                        'color'   => $p->color_pro ?? '',
                        'tipo'    => $p->tipo_pro ?? '',
                        'formato' => $p->formato_pro ?? '',
                        'unidad'  => $p->unidadMedida ?? '',
                        'precio'  => (float) $p->precioUnitario_pro,
                    ];
                })
                ->values()
                ->all();
        } catch (\Throwable $e) {
            return [];
        }
    }

    // Regresa el id_pro_pk del producto registrado que corresponde a una fila del formulario
    private function resolverProducto(array $it)
    {
        // Si el formulario ya trae el id (producto elegido del catálogo), se valida y se usa
        if (!empty($it['id_pro']) && is_numeric($it['id_pro'])) {
            $existe = productosregistradosModel::where('id_pro_pk', (int) $it['id_pro'])->value('id_pro_pk');
            if ($existe) {
                return $existe;
            }
        }

        // Si no, se busca por nombre (y tipo / unidad / color si se indicaron)
        $q = productosregistradosModel::where('estado_pro', '1')->where('nombre_pro', $it['nombre']);
        if (!empty($it['tipo'])) {
            $q->where('tipo_pro', $it['tipo']);
        }
        if (!empty($it['unidad'])) {
            $q->where('unidadMedida', $it['unidad']);
        }
        if (!empty($it['color'])) {
            $q->where('color_pro', $it['color']);
        }

        $id = $q->orderBy('id_pro_pk')->value('id_pro_pk');
        if (!$id) {
            throw new \Exception(
                "El producto '{$it['nombre']}' ({$it['tipo']}, {$it['unidad']}"
                . (!empty($it['color']) ? ", {$it['color']}" : '')
                . ") no está registrado. Regístralo primero en Productos registrados o elígelo de la lista sugerida."
            );
        }

        return $id;
    }

    // Productos de una cotización, en el formato que usa el formulario
    private function productosDeCotizacion($idCotizacion)
    {
        if (!Schema::connection('mysql')->hasTable($this->tablaDetalle)) {
            return [];
        }

        $c = $this->colDetalle;

        $filas = DB::connection('mysql')->table($this->tablaDetalle)
            ->where($c['cotizacion'], $idCotizacion)
            ->get();

        $ids   = $filas->pluck($c['producto'])->unique()->all();
        $prods = productosregistradosModel::whereIn('id_pro_pk', $ids)->get()->keyBy('id_pro_pk');

        return $filas->map(function ($r) use ($c, $prods) {
            $idPro = $r->{$c['producto']};
            $p     = $prods->get($idPro);

            return [
                'id_pro'   => $idPro,
                'nombre'   => $p->nombre_pro ?? '',
                'color'    => $p->color_pro ?? '',
                'tipo'     => $p->tipo_pro ?? '',
                'unidad'   => $p->unidadMedida ?? '',
                'cantidad' => (int) ($r->{$c['cantidad']} ?? 1),
                'precio'   => (float) ($r->{$c['precio']} ?? 0),
            ];
        })->values()->all();
    }

    // Valida y recalcula los productos que mandó el formulario (JSON).
    
    private function leerProductos($json)
    {
        $lista = json_decode((string) $json, true);

        if (!is_array($lista) || count($lista) === 0) {
            return [null, 0, 'Agrega al menos un producto a la cotización'];
        }

        $items = [];
        $total = 0;

        foreach ($lista as $i => $p) {
            $nombre   = trim((string) ($p['nombre'] ?? ''));
            $tipo     = trim((string) ($p['tipo'] ?? ''));
            $unidad   = trim((string) ($p['unidad'] ?? ''));
            $color    = trim((string) ($p['color'] ?? ''));
            $cantidad = $p['cantidad'] ?? null;
            $precio   = $p['precio'] ?? null;

            if ($nombre === '' || $tipo === '' || $unidad === '') {
                return [null, 0, 'El producto #' . ($i + 1) . ' está incompleto'];
            }
            if (!is_numeric($cantidad) || (int) $cantidad < 1) {
                return [null, 0, 'La cantidad del producto #' . ($i + 1) . ' no es válida'];
            }
            if (!is_numeric($precio) || (float) $precio < 0) {
                return [null, 0, 'El precio del producto #' . ($i + 1) . ' no es válido'];
            }

            $cantidad = (int) $cantidad;
            $precio   = round((float) $precio, 2);
            $subtotal = round($cantidad * $precio, 2);
            $total   += $subtotal;

            $items[] = [
                'id_pro'   => $p['id_pro'] ?? null,
                'nombre'   => $nombre,
                'color'    => $color,
                'tipo'     => $tipo,
                'unidad'   => $unidad,
                'cantidad' => $cantidad,
                'precio'   => $precio,
                'subtotal' => $subtotal,
            ];
        }

        return [$items, round($total, 2), null];
    }

    // Inserta las filas de detalle de una cotización
    private function guardarDetalle($idCotizacion, array $items)
    {
        $c = $this->colDetalle;
        $filas = [];

        foreach ($items as $it) {
            $filas[] = [
                $c['cotizacion'] => $idCotizacion,
                $c['producto']   => $this->resolverProducto($it),
                $c['cantidad']   => $it['cantidad'],
                $c['precio']     => $it['precio'],
                $c['subtotal']   => $it['subtotal'],
            ];
        }

        DB::connection('mysql')->table($this->tablaDetalle)->insert($filas);
    }


    private function reglas()
    {
        return [
            'nombre'           => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'fecha'            => 'required|date_format:d/m/Y',
            'productos_json'   => 'required|string',
        ];
    }

    private function mensajes()
    {
        return [
            'nombre.required'           => 'Ingresa el nombre del cliente',
            'apellido_paterno.required' => 'Ingresa el apellido paterno',
            'fecha.required'            => 'Selecciona la fecha de solicitud',
            'fecha.date_format'         => 'La fecha debe tener el formato dd/mm/aaaa',
            'productos_json.required'   => 'Agrega al menos un producto a la cotización',
        ];
    }

    private function sinTablaDetalle()
    {
        return !Schema::connection('mysql')->hasTable($this->tablaDetalle);
    }

    private function mensajeSinTablaDetalle()
    {
        return "No existe la tabla '{$this->tablaDetalle}'.";
    }

    // Se conserva por si alguna ruta antigua todavía llama a MiInterfaz8
    public function MiInterfaz8()
    {
        return $this->vistacrearcotizacion();
    }

    public function vistacrearcotizacion()
    {
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        $cotizacion = null;
        $cliente    = ['nombre' => '', 'paterno' => '', 'materno' => ''];
        $productos  = [];
        $catalogo   = $this->catalogoProductos();
        return view('registro_cotizaciones', compact('cotizacion', 'cliente', 'productos', 'catalogo'));
    }

    public function guardarcotizacion(Request $request)
    {
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        $request->validate($this->reglas(), $this->mensajes());

        [$items, $total, $errorProd] = $this->leerProductos($request->productos_json);
        if ($errorProd) {
            return back()->withInput()->with('error', $errorProd);
        }
        if ($this->sinTablaDetalle()) {
            return back()->withInput()->with('error', $this->mensajeSinTablaDetalle());
        }

        $fecha    = \DateTime::createFromFormat('d/m/Y', $request->fecha);
        $fechaSql = $fecha->format('Y-m-d');
        $vence    = (clone $fecha)->modify('+' . $this->diasVigencia . ' days')->format('Y-m-d');

        try {
            DB::connection('mysql')->transaction(function () use ($request, $items, $total, $fechaSql, $vence) {
                $idCli = $this->buscarOCrearCliente(
                    trim($request->nombre),
                    trim($request->apellido_paterno),
                    trim((string) $request->apellido_materno)
                );

                $idCot = cotizacionModel::insertGetId([
                    'id_cli_pk'            => $idCli,
                    'id_usu_pk'            => session('usuario_id'),   // el vendedor es quien tiene la sesión
                    'fecha_cot'            => $fechaSql,
                    'fechaVencimiento_cot' => $vence,
                    'total_cot'            => $total,
                ], 'id_cot_pk');

                $this->guardarDetalle($idCot, $items);
            });
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'No se pudo guardar: ' . $e->getMessage());
        }

        return redirect('/cotizacion')->with('ok', 'La cotización se registró con éxito');
    }

    public function vistaeditarcotizacion($id)
    {
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        try {
            $cotizacion = cotizacionModel::where('id_cot_pk', $id)->first();

            if (!$cotizacion) {
                return redirect('/cotizacion')->with('error', 'La cotización no existe');
            }

            $cliente   = $this->datosCliente($cotizacion->id_cli_pk);
            $productos = $this->productosDeCotizacion($id);
            $catalogo  = $this->catalogoProductos();
        } catch (\Throwable $e) {
            return response("Error al consultar la base de datos: " . $e->getMessage(), 500);
        }

        return view('registro_cotizaciones', compact('cotizacion', 'cliente', 'productos', 'catalogo'));
    }

    public function actualizarcotizacion(Request $request, $id)
    {
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        $request->validate($this->reglas(), $this->mensajes());

        [$items, $total, $errorProd] = $this->leerProductos($request->productos_json);
        if ($errorProd) {
            return back()->withInput()->with('error', $errorProd);
        }
        if ($this->sinTablaDetalle()) {
            return back()->withInput()->with('error', $this->mensajeSinTablaDetalle());
        }

        $fecha    = \DateTime::createFromFormat('d/m/Y', $request->fecha);
        $fechaSql = $fecha->format('Y-m-d');
        $vence    = (clone $fecha)->modify('+' . $this->diasVigencia . ' days')->format('Y-m-d');

        try {
            DB::connection('mysql')->transaction(function () use ($request, $id, $items, $total, $fechaSql, $vence) {
                $idCli = $this->buscarOCrearCliente(
                    trim($request->nombre),
                    trim($request->apellido_paterno),
                    trim((string) $request->apellido_materno)
                );

                cotizacionModel::where('id_cot_pk', $id)->update([
                    'id_cli_pk'            => $idCli,
                    'fecha_cot'            => $fechaSql,
                    'fechaVencimiento_cot' => $vence,
                    'total_cot'            => $total,
                ]);

                // Se reemplaza el detalle completo por lo que quedó en el formulario
                DB::connection('mysql')->table($this->tablaDetalle)
                    ->where($this->colDetalle['cotizacion'], $id)->delete();

                $this->guardarDetalle($id, $items);
            });
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'No se pudo actualizar: ' . $e->getMessage());
        }

        return redirect('/cotizacion')->with('ok', 'La cotización se actualizó con éxito');
    }


    public function eliminarcotizacion($id)
    {
        if ($this->sinSesion()) {
            return redirect('/login');
        }

        try {
            DB::connection('mysql')->transaction(function () use ($id) {
                if (!$this->sinTablaDetalle()) {
                    DB::connection('mysql')->table($this->tablaDetalle)
                        ->where($this->colDetalle['cotizacion'], $id)->delete();
                }
                cotizacionModel::where('id_cot_pk', $id)->delete();
            });
        } catch (\Throwable $e) {
            return redirect('/cotizacion')->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }

        return redirect('/cotizacion')->with('ok', 'La cotización se eliminó con éxito');
    }
}