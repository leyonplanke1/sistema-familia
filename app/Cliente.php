<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
     protected $fillable = ['nombre','iddocumento','num_documento','direccion','telefono','email'];
}
