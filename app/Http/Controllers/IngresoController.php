<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ingreso;
use App\detalle_ingreso;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\IngresoFormRequest;


use Carbon\Carbon;
use Response;
use Illuminate\Support\Collections;

// importamos libreria de PDF
use PDF;


class IngresoController extends Controller
{



	public function index(Request $request)	{
		// $tipo = $request ->get('tipo');
		$buscar = $request -> buscar;		

		$ingresos = DB::table('ingresos as i')
		->join('proveedors as p', 'i.idproveedor', '=', 'p.id')
		->join('detalle_ingresos as di', 'i.id', '=', 'di.idingreso')
		->select('i.id','i.fecha','p.nombre', 'i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado', DB::raw('sum(((di.cantidad * precio_compra)*(i.impuesto / 100)) + (di.cantidad * precio_compra)) as total'))
		->where('i.fecha','LIKE', '%'.$buscar.'%') 
		->orWhere('p.nombre','like', '%'.$buscar.'%')
		->orWhere('i.tipo_comprobante','like', '%'.$buscar.'%')
		->orderBy('i.id','asc') 
		->groupBy('i.id','i.fecha','p.nombre', 'i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
		->paginate(10);
		return $ingresos;

		// return ingreso::all();
	}


	public function create()	{


	}


	public function store(Request $request)	{
		try {

			DB::beginTransaction();
			$ingreso=new Ingreso;
			$ingreso -> idproveedor = $request -> idproveedor;
			$ingreso -> tipo_comprobante = $request -> tipo_comprobante;
			$ingreso -> serie_comprobante = $request -> serie_comprobante;
			$ingreso -> num_comprobante = $request -> num_comprobante;
			$mytime = Carbon::now('America/Lima');
			$ingreso -> fecha=$mytime->toDateTimeString();
			$imp = $request -> impuesto;

			if ($imp != "" ) {
				$ingreso -> impuesto = $request -> impuesto;
			}else{
				$ingreso -> impuesto = 0;
			}			
			$ingreso -> estado = 'ACTIVO';
			$ingreso -> save();

			// empieza el detalle
			$detalle_array = $request -> detalles;

			for ($i=0; $i < count($detalle_array); $i++) { 
				$detalle = new detalle_ingreso();
				$detalle -> idingreso     = $ingreso -> id;
				$detalle -> idarticulo    = (int)$detalle_array[$i]['det_idarticulo']; 
				$detalle -> cantidad      = (int)$detalle_array[$i]['det_cantidad'];
				$detalle -> precio_compra = (float)$detalle_array[$i]['det_precio_compra'];
				$detalle -> precio_venta  = (float)$detalle_array[$i]['det_precio_venta'];
				$detalle -> save();
			}


			DB::commit();

		} catch (Exception $e) {
			DB::rollback();
		}

		return $ingreso;
	}


	public function show($id)	{

		
		$ingresos = DB::table('ingresos as i')
		->join('proveedors as p', 'i.idproveedor', '=', 'p.id')
		->join('detalle_ingresos as di', 'i.id', '=', 'di.idingreso')
		->select('i.id','i.fecha','p.id as idproveedor','p.nombre','p.num_documento', 'i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado', DB::raw('sum(((di.cantidad * precio_compra)*(i.impuesto / 100)) + (di.cantidad * precio_compra)) as total'))
		->where('i.id','=',$id)
		->groupBy('i.id','i.fecha','p.nombre', 'i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
		->get();

		return $ingresos   ; 
	}
	
	public function verdetalle($id)	{ 		 

		$detalles = DB::table('detalle_ingresos as d')
		->join('articulos as a', 'd.idarticulo', '=', 'a.id') 
		->select('d.id','d.idingreso','d.idarticulo','a.nombre as articulo','d.cantidad','d.precio_compra', 'd.precio_venta')
		->where('d.idingreso','=',$id)
		->get(); 

		return $detalles  ; 
	}

	 


	// public function edit($id)	{
	// 	$articulo = Articulo::findOrFail($id);
	// 	$categorias = DB::table('categorias')-> where('condicion','=','1')->get(); 
	// 	return view('almacen.articulo.edit', ["articulo"=>$articulo, "categorias" => $categorias]);


	// }


	public function update(Request $request, $id)	{
		
		$ingreso = Ingreso::findOrFail($id);
  
		$ingreso -> idproveedor = $request -> idproveedor;
		$ingreso -> tipo_comprobante = $request -> tipo_comprobante;
		$ingreso -> serie_comprobante = $request -> serie_comprobante;
		$ingreso -> num_comprobante = $request -> num_comprobante;

		$imp = $request -> impuesto;

		if ($imp != "" ) {
			$ingreso -> impuesto = $request -> impuesto;
		}else{
			$ingreso -> impuesto = 0;
		}

		$ingreso -> update();
		return $ingreso;
	
	}


	public function destroy($id)	{ 

		$ingreso=Ingreso::findOrFail($id);
		$ingreso->estado='ANULADO';
		$ingreso->update(); 

		return $ingreso;
	}

	public function pdfdetalles($id){

		$ingresos = DB::table('ingresos as i')
		->join('personas as p', 'i.idproveedor', '=', 'p.id')
		->join('detalle_ingresos as di', 'i.id', '=', 'di.idingreso')
		->select('i.id','i.fecha_hora','p.nombre','p.direccion','p.num_documento', 'i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado', DB::raw('sum(di.cantidad * precio_compra) as total'))
		->where('i.id','=',$id)
		->groupBy('i.id','i.fecha_hora','p.nombre','p.direccion','p.num_documento', 'i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
		->first();

		$detalles = DB::table('detalle_ingresos as d')
		->join('articulos as a', 'd.idarticulo', '=', 'a.id') 
		->select('a.nombre as articulo','d.cantidad','d.precio_compra', 'd.precio_venta')
		->where('d.idingreso','=',$id)
		->get();


		$pdf = PDF::loadView('compras.ingreso.reporte-detalle',["ingresos"=>$ingresos,"detalles"=>$detalles]);
    	// return $pdf -> download('productos.pdf');
		return $pdf -> stream('comprobante-ingresos.pdf');
	}


	public function pdfreporteingresos(){

		$ingresos = DB::table('ingresos as i')
		->join('personas as p', 'i.idproveedor', '=', 'p.id')
		->join('detalle_ingresos as di', 'i.id', '=', 'di.idingreso')
		->select('i.id','i.fecha_hora','p.nombre', 'i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado', DB::raw('sum(di.cantidad * precio_compra) as total'))
		->orderBy('i.id','desc')
		->groupBy('i.id','i.fecha_hora','p.nombre', 'i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
		->paginate(10);


		$pdf = PDF::loadView('compras.ingreso.reporte-ingresos',["ingresos"=>$ingresos])->setPaper('a4', 'landscape');
    	// return $pdf -> download('productos.pdf'); 
		return $pdf -> stream('Lista-compras.pdf');
	}


}
