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

Route::get('/get-points-user', 'GetController@getPointsUser')->name('api.get.poinst.user');

