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

Route::post('login', 'UserAuth\UserController@login');
Route::post('register', 'UserAuth\UserController@register');

Route::get('/displaySeatDatawithprofile/{id}','UserAuth\UserController@seatDetailsWithprofile');
Route::get('/mealdetails','UserAuth\UserController@mealdetails');


Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'UserAuth\UserController@details');
Route::post('/mealdonation','UserAuth\UserController@foundationmeal');


Route::post('/Seats','UserAuth\UserController@CreateSeat');
Route::post('/SeatsDetails','UserAuth\UserController@SeatsDetails');
Route::put('/SeatStatusUpdate','UserAuth\UserController@SeatStatusUpdate');

Route::post('/EditProfile','UserAuth\UserController@EditProfile');

Route::post('/displayProfileData','UserAuth\UserController@displayProfileData');



});

