<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Proveedor;

class ProveedorController extends Controller
{
    
	public function index(Request $request)
	{
		// return Proveedor::scopeBuscarpor($request->buscar);
		$query = $request -> buscar;

		$proveedores = DB::table('proveedors as  p')
		-> join('documentos as d','p.iddocumento','=', 'd.id')
		-> select('p.id', 'p.nombre', 'd.tipo_documento', 'p.num_documento', 'p.direccion', 'p.telefono','p.email') 

		->where('p.nombre','LIKE','%'.$query.'%')  
    	->orWhere('p.num_documento','like', "%$query%") 
    	->orWhere('p.direccion','like', "%$query%") 
    	->orWhere('p.telefono','like', "%$query%") 
		->orderBy('id','desc')
		->paginate(10) ;

		return $proveedores;
	}

public function indexdashboard(Request $request)
	{
		// return Proveedor::scopeBuscarpor($request->buscar);
		$query = $request -> buscar;

		$proveedores = DB::table('proveedors as  p')
		-> join('documentos as d','p.iddocumento','=', 'd.id')
		-> select('p.id', 'p.nombre', 'd.tipo_documento', 'p.num_documento', 'p.direccion', 'p.telefono','p.email') 

		->where('p.nombre','LIKE','%'.$query.'%')  
    	->orWhere('p.num_documento','like', "%$query%") 
    	->orWhere('p.direccion','like', "%$query%") 
    	->orWhere('p.telefono','like', "%$query%") 
		->orderBy('id','desc')
		->paginate(5) ;

		return $proveedores;
	}


	public function store(Request $request)
	{
		// return Articulo::create($request->all());

		$proveedor = new Proveedor;
		$proveedor -> nombre = $request -> nombre;
		$proveedor -> iddocumento = $request -> iddocumento;
		$proveedor -> num_documento = $request -> num_documento;
		$proveedor -> direccion = $request -> direccion;
		$proveedor -> telefono = $request -> telefono;
		$proveedor -> email = $request -> email;
		// $proveedor -> imagen = $request -> imagen;
		// $proveedor -> imagen = 'imagenprueba.png';

		// $file = $request->file('TxtImagen');
		// $file -> move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
		// $proveedor -> imagen = $file -> getClientOriginalName();		
		
		$proveedor -> save();

		return $proveedor;
	}



	public function show($id)
	{
		return Proveedor::findOrFail($id);

		// $articulos=DB::table('articulos as a')
		// -> join('categorias as c','a.idcategoria','=', 'c.id')
		// -> select('a.id', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria_nom', 'a.descripcion','a.imagen','a.estado') 
		// ->orderBy('a.id','desc')
		// ->paginate(10);

		// return $articulos;
	}

	public function edit($id)
	{
       // return Articulo::findOrFail($id);

	}


	public function update(Request $request, $id)
	{
		 
		$proveedor = Proveedor::findOrFail($id);

		$proveedor -> nombre = $request -> nombre;
		$proveedor -> iddocumento = $request -> iddocumento;
		$proveedor -> num_documento = $request -> num_documento;
		$proveedor -> direccion = $request -> direccion;
		$proveedor -> telefono = $request -> telefono;
		$proveedor -> email = $request -> email;

		// $proveedor -> imagen = 'imagenprueba.png';

		// $file = $request->file('TxtImagen');
		// $file -> move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
		// $proveedor -> imagen = $file -> getClientOriginalName();	

		$proveedor -> update();

		return $proveedor;
	}


	public function destroy($id)
	{
		$proveedor = Proveedor::findOrFail($id);
		$proveedor->delete();
	}
}
