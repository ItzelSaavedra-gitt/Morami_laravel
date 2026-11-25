<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $conn = Schema::connection('mysql');

        // 1. Agregar campos a la tabla `productos`
        if ($conn->hasTable('productos')) {
            $conn->table('productos', function (Blueprint $table) use ($conn) {
                if (!$conn->hasColumn('productos', 'stock_actual')) {
                    $table->integer('stock_actual')->default(0)->after('CantidadPiezas_pro');
                }
                if (!$conn->hasColumn('productos', 'stock_minimo')) {
                    $table->integer('stock_minimo')->nullable()->after('stock_actual');
                }
                if (!$conn->hasColumn('productos', 'stock_maximo')) {
                    $table->integer('stock_maximo')->nullable()->after('stock_minimo');
                }
                if (!$conn->hasColumn('productos', 'rendimiento_caja_pro')) {
                    $table->decimal('rendimiento_caja_pro', 10, 4)->nullable()->after('formato_pro');
                }
                if (!$conn->hasColumn('productos', 'es_sobre_pedido')) {
                    $table->boolean('es_sobre_pedido')->default(false)->after('estado_pro');
                }
            });
        }

        // 2. Crear una sola tabla para entregas parciales
        if ($conn->hasTable('pedidos') && !$conn->hasTable('entregas_pedido')) {
            $conn->create('entregas_pedido', function (Blueprint $table) {
                $table->increments('id_entrega_pk');
                $table->unsignedInteger('id_ped_pk');
                $table->unsignedInteger('id_pro_pk')->nullable();
                $table->date('fecha_entrega_real');
                $table->integer('cantidad_entregada');
                $table->string('estatus_entrega', 30)->default('Parcial');
                $table->text('observaciones')->nullable();
                $table->unsignedInteger('id_usu_pk')->nullable();
                $table->timestamps();

                $table->index('id_ped_pk');
                $table->index('id_pro_pk');
                $table->index('id_usu_pk');
            });
        }
    }

    public function down(): void
    {
        $conn = Schema::connection('mysql');

        $conn->dropIfExists('entregas_pedido');

        if ($conn->hasTable('productos')) {
            $conn->table('productos', function (Blueprint $table) use ($conn) {
                foreach (['es_sobre_pedido', 'rendimiento_caja_pro', 'stock_maximo', 'stock_minimo', 'stock_actual'] as $col) {
                    if ($conn->hasColumn('productos', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};