<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $conn = Schema::connection('mysql');

        // 1. Ampliar estatus_ped en `pedidos` para que quepan estados como "Parcial" o "Entrega parcial"
        if ($conn->hasTable('pedidos') && $conn->hasColumn('pedidos', 'estatus_ped')) {
            DB::connection('mysql')->statement('ALTER TABLE `pedidos` MODIFY COLUMN `estatus_ped` VARCHAR(25) NOT NULL');
        }

        if (!$conn->hasTable('entregas_pedido')) {
            return;
        }

        // 2. Agregar id_dped_pk si no existe y asegurar que las columnas INT coincidan con las PKs
        if (!$conn->hasColumn('entregas_pedido', 'id_dped_pk')) {
            $conn->table('entregas_pedido', function (Blueprint $table) {
                $table->integer('id_dped_pk')->nullable()->after('id_ped_pk');
                $table->index('id_dped_pk');
            });
        }

        DB::connection('mysql')->statement('ALTER TABLE `entregas_pedido` MODIFY COLUMN `id_ped_pk` INT NOT NULL');
        DB::connection('mysql')->statement('ALTER TABLE `entregas_pedido` MODIFY COLUMN `id_dped_pk` INT NULL');
        DB::connection('mysql')->statement('ALTER TABLE `entregas_pedido` MODIFY COLUMN `id_pro_pk` INT NULL');
        DB::connection('mysql')->statement('ALTER TABLE `entregas_pedido` MODIFY COLUMN `id_usu_pk` INT NULL');

        // 3. Crear llaves foráneas en MySQL
        $conn->table('entregas_pedido', function (Blueprint $table) use ($conn) {
            if ($conn->hasTable('pedidos')) {
                $table->foreign('id_ped_pk', 'fk_entregas_pedido_id_ped')
                    ->references('id_ped_pk')
                    ->on('pedidos')
                    ->onDelete('cascade');
            }

            if ($conn->hasTable('detalle_pedido')) {
                $table->foreign('id_dped_pk', 'fk_entregas_pedido_id_dped')
                    ->references('id_dped_pk')
                    ->on('detalle_pedido')
                    ->nullOnDelete();
            }

            if ($conn->hasTable('productos')) {
                $table->foreign('id_pro_pk', 'fk_entregas_pedido_id_pro')
                    ->references('id_pro_pk')
                    ->on('productos')
                    ->nullOnDelete();
            }

            if ($conn->hasTable('usuarios')) {
                $table->foreign('id_usu_pk', 'fk_entregas_pedido_id_usu')
                    ->references('id_usu_pk')
                    ->on('usuarios')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        $conn = Schema::connection('mysql');

        if ($conn->hasTable('entregas_pedido')) {
            $conn->table('entregas_pedido', function (Blueprint $table) {
                $table->dropForeign('fk_entregas_pedido_id_ped');
                $table->dropForeign('fk_entregas_pedido_id_dped');
                $table->dropForeign('fk_entregas_pedido_id_pro');
                $table->dropForeign('fk_entregas_pedido_id_usu');
            });

            if ($conn->hasColumn('entregas_pedido', 'id_dped_pk')) {
                $conn->table('entregas_pedido', function (Blueprint $table) {
                    $table->dropColumn('id_dped_pk');
                });
            }
        }
    }
};