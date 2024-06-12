<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
	protected $fillable = ['idcliente','tipo_comprobante','serie_comprobante','num_comprobante','fecha','impuesto','total_venta','estado'];
}
