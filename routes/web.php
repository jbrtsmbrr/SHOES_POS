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

// Route::get('/inventory_system', function () {
//   return view('/masterfile/test');
// });

Route::group(["prefix" => "/inventory_system"], function() {
  Route::get("/", function() {
    return view('index');
  });

  Route::get("/dashboard", function() {
    return view('/masterfile/test');
  });
});

Route::group(["prefix" => "/inventory_system/product"], function() {
  Route::get("/", "productController@index");
  Route::post("/insert", "productController@insert");
  Route::get("/lookup/{lookuptype}", "productController@lookup");
  Route::post("/reqProduct", "productController@reqProduct");
  Route::post("/reqUom", "productController@reqUom");
  Route::post("/saveUom", "productController@saveUom");

  Route::get("/dummyData", "productController@dummyData");
});
