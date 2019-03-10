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

// Patients
Route::resource('/patients', 'Patient\PatientController');
Route::get('/patient/datatable', 'Patient\PatientController@getPatientDataTable')->name('patient.datatable');
Route::any('/patient/csv', 'Stock\StockController@getStockCsv')->name('patient.csv');

// Stocks
Route::resource('/stocks', 'Stock\StockController');
Route::get('/stock/datatable', 'Stock\StockController@getStockDataTable')->name('stock.datatable');
Route::any('/stock/csv', 'Stock\StockController@getStockCsv')->name('stock.csv');
