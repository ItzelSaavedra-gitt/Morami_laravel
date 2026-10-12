<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productosregistradosModel extends Model
{
    protected $connection = 'mysql';
    protected $table = 'productos';
    public $timestamps = false;
}
