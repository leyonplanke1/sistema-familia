<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Cliente;

class ClienteController extends Controller
{
    public function index(Request $request)
	{
		// return Proveedor::scopeBuscarpor($request->buscar);
		$query = $request -> buscar;

		$proveedores = DB::table('clientes as  c')
		-> join('documentos as d','c.iddocumento','=', 'd.id')
		-> select('c.id', 'c.nombre', 'd.tipo_documento', 'c.num_documento', 'c.direccion', 'c.telefono','c.email') 

		->where('c.nombre','LIKE','%'.$query.'%')  
    	->orWhere('c.num_documento','like', "%$query%") 
    	->orWhere('c.direccion','like', "%$query%") 
    	->orWhere('c.telefono','like', "%$query%") 
		->orderBy('id','desc')
		->paginate(10) ;

		return $proveedores;
	}

	public function indexdashboard(Request $request)
	{
		// return Proveedor::scopeBuscarpor($request->buscar);
		$query = $request -> buscar;

		$proveedores = DB::table('clientes as  c')
		-> join('documentos as d','c.iddocumento','=', 'd.id')
		-> select('c.id', 'c.nombre', 'd.tipo_documento', 'c.num_documento', 'c.direccion', 'c.telefono','c.email') 

		->where('c.nombre','LIKE','%'.$query.'%')  
    	->orWhere('c.num_documento','like', "%$query%") 
    	->orWhere('c.direccion','like', "%$query%") 
    	->orWhere('c.telefono','like', "%$query%") 
		->orderBy('id','desc')
		->paginate(5) ;

		return $proveedores;
	}

	public function store(Request $request)
	{
		// return Articulo::create($request->all());

		$clientes = new Cliente;
		$clientes -> nombre = $request -> nombre;
		$clientes -> iddocumento = $request -> iddocumento;
		$clientes -> num_documento = $request -> num_documento;
		$clientes -> direccion = $request -> direccion;
		$clientes -> telefono = $request -> telefono;
		$clientes -> email = $request -> email;
		 	
		
		$clientes -> save();

		return $clientes;
	}

	public function show($id)
	{
		return Cliente::findOrFail($id);
 
	}

	public function update(Request $request, $id)
	{
		 
		$clientes = Cliente::findOrFail($id);

		$clientes -> nombre = $request -> nombre;
		$clientes -> iddocumento = $request -> iddocumento;
		$clientes -> num_documento = $request -> num_documento;
		$clientes -> direccion = $request -> direccion;
		$clientes -> telefono = $request -> telefono;
		$clientes -> email = $request -> email;
 

		$clientes -> update();

		return $clientes;
	}

	public function destroy($id)
	{
		$clientes = Cliente::findOrFail($id);
		$clientes->delete();
	}

}
