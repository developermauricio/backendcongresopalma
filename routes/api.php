<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/set-points', 'Controller@setPoints')->name('api.set.points');
Route::post('/set-users-auth', 'Controller@setUserAuth')->name('api.set.user.auth');
Route::post('/set-login-user', 'Controller@setLoginUser')->name('api.set.login.user');

Route::post('/go-conference', 'Controller@goConference');

Route::get('/get-points-user/{email}', 'GetController@getPointsUser')->name('api.get.poinst.user');
Route::get('/get-points-of-user/{email}', 'GetController@getPointsOfUser');
Route::get('/get-points-ranking-users', 'GetController@getRankingPointsUsers');
Route::get('/get-list-points-user', 'GetController@getListPointsUser');
Route::get('/get-users-auth', 'GetController@getUsersAuth')->name('api.get.auth.user');

// cambiar link del eframe
Route::get('/get-link-eframe', 'GetController@getLinkeframe');


