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
    return redirect()->route('home');
});

Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/test/{code}', 'HomeController@test')->name('test');

	Route::resources([
	    'districts' => 'DistrictController',
	    'towns' => 'TownController',
	    'products' => 'ProductController',
	    'distributors' => 'DistributorController',
	    'retailers' => 'RetailerController',
	    'sales' => 'SalesController',
	    'users' => 'UserController',
	    'recepients' => 'EmailrecepientController'
	]);

	Route::get('/districts/import/from-csv',[
			'uses' => 'DistrictController@import',
			'as' => 'districts.import',
		]
	);

	Route::post('/sales/search','SalesController@search')->name('sales.search');
	Route::get('/sales/search/{form}/{to}','SalesController@getsearch')->name('sales.getsearch');
	Route::get('/sales/download/{form}/{to}','SalesController@download')->name('sales.download');

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

	Route::get('/distributors/import/from-csv','DistributorController@import')->name('distributors.import');
	Route::post('/distributors/import/from-csv','DistributorController@handleimport')->name('distributors.handleimport');

	Route::get('/communications/email/create','EmailController@create')->name('email.create');
	Route::get('/communications/email/edit/{id}','EmailController@edit')->name('email.edit');
	Route::post('/communications/email/','EmailController@store')->name('email.store');
	Route::put('/communications/email/update/{id}','EmailController@update')->name('email.update');


	Route::get('/communications/ftp/create','FtpController@create')->name('ftp.create');
	Route::get('/communications/ftp/edit/{id}','FtpController@edit')->name('ftp.edit');
	Route::post('/communications/ftp/','FtpController@store')->name('ftp.store');
	Route::put('/communications/ftp/update/{id}','FtpController@update')->name('ftp.update');

	Route::get('/users/{userid}/changepass', 'UserController@getChangePass')->name('users.getChangePass');
	Route::put('/users/{userid}/changepass', 'UserController@changepass')->name('users.changepass');

	Route::get('/changepass', 'UserController@getMyChangePass')->name('users.getMyChangePass');
	Route::put('/changepass', 'UserController@mychangepass')->name('users.mychangepass');

});


Route::get('/email/test','EmailController@test')->name('email.test');
Route::get('/ftp/test','FtpController@test')->name('ftp.test');

Route::get('/task/sendmail/runeod', 'TaskController@runeod')->name('runeod');



