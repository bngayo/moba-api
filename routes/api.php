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

Route::post('login')->uses('API\AuthController@login')->middleware('guest');
Route::post('user/register')->uses('API\RegisterController@store')->middleware('guest');
Route::middleware('auth:sanctum')->post('user/{user}/update_school_info')->uses('API\RegisterController@updateSchoolInfo');
Route::middleware('auth:sanctum')->post('user/{user}/subscribe')->uses('API\SubscriptionController@store');
Route::post('reset_password')->uses('API\AuthController@resetPassword')->middleware('guest');

Route::get('/subscription/plans')->uses('API\SubscriptionPlanController@index')->middleware('guest');

Route::post('transaction/validation')->name('mpesa.validation')->uses('MpesaController@mpesaValidation')->middleware('guest');
Route::post('transaction/confirmation')->name('mpesa.confirmation')->uses('MpesaController@mpesaConfirmation')->middleware('guest');

Route::middleware('auth:sanctum')->get('/user', 'API\AuthController@getUser');
