<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\venta;
use App\detalle_venta;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input; 


use Carbon\Carbon;
use Response;
use Illuminate\Support\Collections;

// importamos libreria de PDF
use PDF;


class VentaController extends Controller
{
    public function index(Request $request)	{
		// $tipo = $request ->get('tipo');
		$buscar = $request -> buscar;		

		$ventas = DB::table('ventas as v')
		->join('clientes as c', 'v.idcliente', '=', 'c.id') 
		->select('v.id','v.fecha','c.nombre', 'v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado', 'total_venta') 
		->where('v.fecha','LIKE', '%'.$buscar.'%') 
		->orWhere('c.nombre','like', '%'.$buscar.'%')
		->orWhere('v.tipo_comprobante','like', '%'.$buscar.'%')
		->orderBy('v.id','asc') 
		->groupBy('v.id','v.fecha','c.nombre', 'v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
		->paginate(10);
		return $ventas;

		// return venta::all();
	}

	public function store(Request $request)	{
		try {

			DB::beginTransaction();
			$venta=new venta;
			$venta -> idcliente = $request -> idcliente;
			$venta -> tipo_comprobante = $request -> tipo_comprobante;
			$venta -> serie_comprobante = $request -> serie_comprobante;
			$venta -> num_comprobante = $request -> num_comprobante;
			$venta -> total_venta = $request -> total_venta;

			$mytime = Carbon::now('America/Lima');
			$venta -> fecha=$mytime->toDateTimeString();
			$imp = $request -> impuesto;

			if ($imp != "" ) {
				$venta -> impuesto = $request -> impuesto;
			}else{
				$venta -> impuesto = 0;
			}			
			$venta -> estado = 'A';
			$venta -> save();

			// empieza el detalle
			$detalle_array = $request -> detalles;

			for ($i=0; $i < count($detalle_array); $i++) { 

				$detalle = new detalle_venta();
				$detalle -> idventa       = $venta -> id;
				$detalle -> idarticulo    = (int)$detalle_array[$i]['det_idarticulo'];
				$detalle -> cantidad      = (int)$detalle_array[$i]['det_cantidad'];
				$detalle -> precio 		  = (float)$detalle_array[$i]['det_precio_venta'];
				$detalle -> descuento 	  = (float)$detalle_array[$i]['det_descuento'];
				$detalle -> save();

			}


			DB::commit();

		} catch (Exception $e) {
			DB::rollback();
		}

		return $venta;
	}

	public function show($id)	{

		
		$ventas = DB::table('ventas as v')
		->join('clientes as p', 'v.idcliente', '=', 'p.id')
		->join('detalle_ventas as dv', 'v.id', '=', 'dv.idventa')
		->select('v.id','v.fecha','p.id as idproveedor','p.nombre','p.num_documento', 'v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
		->where('v.id','=',$id)
		->groupBy('v.id','v.fecha','p.nombre', 'v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
		->get();

		return $ventas   ; 
	}
	
	public function verdetalle($id)	{ 		 

		$detalles = DB::table('detalle_ventas as d')
		->join('articulos as a', 'd.idarticulo', '=', 'a.id') 
		->select('d.id','d.idventa','d.idarticulo','a.nombre as articulo','d.cantidad','d.precio', 'd.descuento')
		->where('d.idventa','=',$id)
		->get(); 

		return $detalles  ; 
	}


	public function articuloStockPrecioVenta($id)	{
 
		$articulos = DB::table('articulos as art')
		->join('detalle_ingresos as di','art.id', '=', 'di.idarticulo')
		->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) as articulo'),'art.id', 'art.stock', DB::raw('avg(di.precio_venta) as precio_promedio'))
		->where('art.id','=',$id)
		->where('art.stock','>','0')
		->groupBy('articulo','art.id', 'art.stock')
		->get();

		return $articulos;
	}



	public function destroy($id)	{ 

		$ventas=venta::findOrFail($id);
		$ventas->estado='C';
		$ventas->update(); 

		return $ventas;
	}
}
