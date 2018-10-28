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

use Bigcommerce\Api\Client;

Route::get('/', function () {
    $time = Client::getTime();
    return view('welcome', [
        'time' => $time ? $time->format('H:i:s') : 'N/A',
    ]);
});

Route::get('/customers', 'CustomersController@index');

Route::get('/customers/{id}', 'CustomerDetailsController@show');
