<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ingreso extends Model
{
     protected $fillable = ['idproveedor','tipo_comprobante','serie_comprobante','num_comprobante','fecha','impuesto','estado'];

     public static function scopeBuscarpor($query=''){
    	if ( !$query ) {
    		return self::all();
    	}
    	return self::where('nombre','like', "%$query%")
    	->orWhere('tipo_comprobante','like', "%$query%")
    	->orWhere('num_comprobante','like', "%$query%")
    	->get();
    }
}
