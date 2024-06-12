<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_ingreso extends Model
{
    protected $fillable = ['idingreso','idarticulo' ,'cantidad','precio_compra','precio_venta'];
}
