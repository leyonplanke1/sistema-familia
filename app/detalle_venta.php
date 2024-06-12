<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_venta extends Model
{
    protected $fillable = ['idventa','idarticulo' ,'cantidad','precio','descuento'];
}
