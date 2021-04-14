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

Route::get('/test', function (Request $request) {
    echo 'Api testing....';
});

Route::post('login')->uses('API\AuthController@login')->middleware('guest');
Route::post('register')->uses('API\AuthController@register')->middleware('guest');
Route::post('reset_password')->uses('API\AuthController@resetPassword')->middleware('guest');

Route::post('stk_push')->uses('MPesaController@customerMpesaSTKPush')->middleware('guest');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
