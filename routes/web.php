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

    Route::get('/test/{code}', 'HomeController@test')->name('test');

	Route::resources([
	    'districts' => 'DistrictController',
	    'towns' => 'TownController',
	    'products' => 'ProductController',
	    'retailers' => 'RetailerController',
	    'sales' => 'SalesController',
	    'users' => 'UserController'
	]);

	Route::get('/districts/import/from-csv',[
			'uses' => 'DistrictController@import',
			'as' => 'districts.import',
		]
	);
	Route::post('/districts/import/from-csv','DistrictController@handleImport')->name('districts.handleimport');

	Route::get('/retailers/getinfo/{code}', 'RetailerController@getinfo')->name('retailers.getinfo');
	Route::get('/sales/orderdetails/add', 'SalesController@addorderdetails')->name('sales.addorderdetails');

	Route::get('/sales/getprice/{id}', 'SalesController@getprice')->name('sales.getprice');

	Route::get('/products/import/from-csv','ProductController@import')->name('products.import');
	Route::post('/products/import/from-csv','ProductController@handleimport')->name('products.handleimport');

	Route::get('/disctricts/import/from-csv','DistrictController@import')->name('disctricts.import');
	Route::post('/disctricts/import/from-csv','DistrictController@handleimport')->name('disctricts.handleimport');

	Route::get('/towns/import/from-csv','TownController@import')->name('towns.import');
	Route::post('/towns/import/from-csv','TownController@handleimport')->name('towns.handleimport');

	Route::get('/retailers/import/from-csv','RetailerController@import')->name('retailers.import');
	Route::post('/retailers/import/from-csv','RetailerController@handleimport')->name('retailers.handleimport');

	Route::get('/communications/email/create','EmailController@create')->name('email.create');
	Route::get('/communications/email/edit/{id}','EmailController@edit')->name('email.edit');
	Route::post('/communications/email/','EmailController@store')->name('email.store');
	Route::put('/communications/email/update/{id}','EmailController@update')->name('email.update');

});

Route::get('/email/test','EmailController@test')->name('email.test');
