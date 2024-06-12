<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\detalle_ingreso;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input; 


use Carbon\Carbon;
use Response;
use Illuminate\Support\Collections;

class DetalleIngresoController extends Controller
{
     
    public function index()
    {
         
    }

     
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
          $detalle = new detalle_ingreso();
            $detalle -> idingreso = $request -> idingreso;
            $detalle -> idarticulo = $request -> idarticulo;
            $detalle -> cantidad = $request -> cantidad;
            $detalle -> precio_compra = $request -> precio_compra;
            $detalle -> precio_venta = $request -> precio_venta;
            
         

            $detalle -> save();
    }

    
    public function show($id)
    {
        //
    }

     
    public function edit($id)
    {
        //
    }

     
    public function update(Request $request, $id)
    {
        $detalles = detalle_ingreso::findOrFail($id);
 
        $detalles -> idarticulo = $request -> idarticulo;
        $detalles -> cantidad = $request -> cantidad;
        $detalles -> precio_compra = $request -> precio_compra;
        $detalles -> precio_venta = $request -> precio_venta; 
 

        $detalles -> update();

        return $detalles;
    }

     
    public function destroy($id)
    {
        $proveedor = detalle_ingreso::findOrFail($id);
        $proveedor->delete();
    }
}
