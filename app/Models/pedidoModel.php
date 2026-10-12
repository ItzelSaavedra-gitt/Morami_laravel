<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedidoModel extends Model
{
    protected $connection = 'mysql';
    protected $table = 'pedidos';
    public $timestamps = false;
}
