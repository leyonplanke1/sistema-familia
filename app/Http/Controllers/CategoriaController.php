<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{
 
    public function index()
    {
        
        return Categoria::all();
    }

  
    
    public function store(Request $request)
    {
        return Categoria::create($request->all());
    }

    
     
    public function show($id)
    {
        return Categoria::findOrFail($id);
    }
 
    public function edit($id)
    {
       // return Categoria::findOrFail($id);
           
    }

    
    public function update(Request $request, $id)
    {
        $cate = Categoria::findOrFail($id);
        $cate->nombre = $request->nombre;
        $cate->descripcion = $request->descripcion;
        $cate->condicion = $request->condicion;
        $cate->update();

        return $cate;
    }

    
    public function destroy($id)
    {
        $cate = Categoria::findOrFail($id);
        $cate->delete();
    }
}
