<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
     protected $fillable = ['nombre','iddocumento','num_documento','direccion','telefono','email'];

     public static function scopeBuscarpor($query=''){
    	if ( !$query ) {
    		return self::all();
    	}
    	return self::where('nombre','like', "%$query%")
    	->orWhere('num_documento','like', "%$query%") 
    	->get();
    }

}
