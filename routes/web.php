<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
	
Auth::routes();
Route::resource('categorias','CategoriaController');
Route::resource('articulos','ArticuloController');
Route::resource('proveedores','ProveedorController');
Route::resource('documentos','DocumentoController');
Route::resource('ingresos','IngresoController');
Route::get('ingresos/detalles/{id}', 'IngresoController@verdetalle')->name('detallesingresos');
Route::resource('ingresos/add-detalles', 'DetalleIngresoController');
Route::resource('clientes','ClienteController');
Route::resource('ventas','VentaController');
Route::get('ventas/detalles/{id}', 'VentaController@verdetalle')->name('detallesventas');
Route::get('clientes-dash/1', 'ClienteController@indexdashboard')->name('clientedash');
Route::get('proveedores-dash/1', 'ProveedorController@indexdashboard')->name('proveedordash');
Route::get('ventas-articulos/{id}', 'VentaController@articuloStockPrecioVenta')->name('ventasarticulos');


Route::get('/home', 'HomeController@index')->name('home');
