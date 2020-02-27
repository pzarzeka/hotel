<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/reservation/add', 'HotelController@reservation');
Route::get('/reservation/{id}', 'HotelController@reservationList');

Route::group(['middleware' => 'basic_auth'], function () {
    Route::post('/reservation/cancel', 'AdminController@reservationCancel');
    Route::post('/reservation/{id}', 'AdminController@reservationList');
});