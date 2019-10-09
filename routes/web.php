<?php

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


Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/home', 'HomeController@index')->name('home');

	Route::resources([
	    'districts' => 'DistrictController',
	    'towns' => 'TownController',
	    'products' => 'ProductController',
	    'retailers' => 'RetailerController',
	    'sales' => 'SalesController',
	]);

	Route::get('/districts/import/from-csv',[
			'uses' => 'DistrictController@import',
			'as' => 'districts.import',
		]
	);
	Route::post('/districts/import/from-csv','DistrictController@handleImport')->name('districts.handleimport');

	Route::get('/retailers/getinfo/{code}', 'RetailerController@getinfo')->name('retailers.getinfo');

	Route::get('/products/import/from-csv','ProductController@import')->name('products.import');
	Route::post('/products/import/from-csv','ProductController@handleimport')->name('products.handleimport');

});
