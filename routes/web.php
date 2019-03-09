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

Route::get('/patients', 'HomeController@index')->name('home');
Route::resource('/stocks', 'Stock\StockController');
Route::get('/stock/datatable', 'Stock\StockController@getStockDataTable')->name('stock.datatable');
Route::any('/stock/csv', 'Stock\StockController@getStockCsv')->name('stock.csv');
