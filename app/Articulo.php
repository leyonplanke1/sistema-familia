<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable = ['idcategoria','codigo','nombre','stock','descripcion','imagen','estado'];

     public static function scopeBuscarpor($query=''){
    	if ( !$query ) {
    		return self::all();
    	}
    	return self::where('nombre','like', "%$query%")
    	->orWhere('codigo','like', "%$query%")
    	->orWhere('stock','like', "%$query%")
    	->get();
    }
}
