<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Articulo;

class ArticuloController extends Controller
{

	public function index(Request $request)
	{
		// return Articulo::scopeBuscarpor($request->buscar);
		$query = $request -> buscar;
		$articulos=DB::table('articulos as a')
		-> join('categorias as c','a.idcategoria','=', 'c.id')
		-> select('a.id', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria_nom', 'a.descripcion','a.imagen','a.estado') 
		->where('a.nombre','like', "%$query%")
    	->orWhere('a.codigo','like', "%$query%")
    	->orWhere('a.stock','like', "%$query%")
		->orderBy('a.id','desc')

		->paginate(10);

		return $articulos;
	}



	public function store(Request $request)
	{
		// return Articulo::create($request->all());

		$articulo = new Articulo;
		$articulo -> idcategoria = $request -> idcategoria;
		$articulo -> codigo = $request -> codigo;		
		$articulo -> nombre = $request -> nombre;
		$articulo -> stock = $request -> stock;
		$articulo -> descripcion = $request -> descripcion;
		$articulo -> estado = 'Activo';
		$articulo -> imagen = $request -> imagen;
		// $articulo -> imagen = 'imagenprueba.png';

		// $file = $request->file('TxtImagen');
		// $file -> move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
		// $articulo -> imagen = $file -> getClientOriginalName();		
		
		$articulo -> save();

		return $articulo;
	}



	public function show($id)
	{
		return Articulo::findOrFail($id);

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
		 
		$articulo = Articulo::findOrFail($id);

		$articulo -> idcategoria = $request -> idcategoria;
		$articulo -> codigo = $request -> codigo;		
		$articulo -> nombre = $request -> nombre;
		$articulo -> stock = $request -> stock;
		$articulo -> descripcion = $request -> descripcion;

		// $articulo -> imagen = 'imagenprueba.png';

		// $file = $request->file('TxtImagen');
		// $file -> move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
		// $articulo -> imagen = $file -> getClientOriginalName();	

		$articulo -> update();

		return $articulo;
	}


	public function destroy($id)
	{
		$articulo = Articulo::findOrFail($id);
		$articulo->delete();
	}
}
