<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productosregistradosModel extends Model
{
    protected $connection = 'mysql';
    protected $table = 'productos';
    protected $primaryKey = 'id_pro_pk';
    public $timestamps = false;

    protected $fillable = [
        'nombre_pro',
        'color_pro',
        'tipo_pro',
        'formato_pro',
        'rendimiento_caja_pro',
        'CantidadPiezas_pro',
        'stock_actual',
        'stock_minimo',
        'stock_maximo',
        'unidadMedida',
        'fechaCaducidad',
        'precioUnitario_pro',
        'estado_pro',
        'es_sobre_pedido',
    ];

    public function getEstadoStockAttribute(): string
    {
        if ((bool) $this->es_sobre_pedido) {
            return 'sobre_pedido';
        }

        $actual = (int) ($this->stock_actual ?? $this->CantidadPiezas_pro ?? 0);

        if (!is_null($this->stock_minimo) && $actual <= (int) $this->stock_minimo) {
            return 'stock_bajo';
        }

        if (!is_null($this->stock_maximo) && $actual >= (int) $this->stock_maximo) {
            return 'stock_alto';
        }

        return 'normal';
    }
}