<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class usuariolModel extends Model
{
    protected $connection = 'mysql';
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usu_pk';
    public $timestamps = false;
}